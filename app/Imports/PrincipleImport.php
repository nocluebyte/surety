<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Row;
use Illuminate\Validation\Rule;
use App\Models\{
    Country,
    State,
    Principle,
    PrincipleType,
    TradeSector,
    BankingLimitCategory,
    FacilityType,
    Designation,
    User,
    ContractorItem,
    ContactDetail,
    TradeSectorItem,
    BankingLimit,
    ProjectTrackRecords,
    OrderBookAndFutureProjects,
    ManagementProfiles,
    Role,
    RatingAgency,
    Rating,
};
use DB;
use Str;
use App\Rules\{
    AlphabetsAndNumbersV3,
    AlphabetsV1,
    GstNo,
    Numbers,
    AlphabetsAndNumbersV1,
    AlphabetsAndNumbersV6,
    AlphabetsV5,
    AlphabetsAndNumbersV2,
    MobileNo,
    PinCode,
    PanNo,
};
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Http\Controllers\CommonController;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Sentinel;

class PrincipleImport implements WithHeadingRow ,WithValidation,SkipsOnFailure  ,OnEachRow,WithChunkReading
{
    use SkipsFailures,Importable;
    private $country;
    private $state;
    private $isCountryIndia;
    private $isJV;
    public function __construct($authManager)
    {
        $this->country = Country::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->state = State::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->principle_type = PrincipleType::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->jvContractor = Principle::select(DB::raw('LOWER(company_name) as company_name'), 'id')->get();
        $this->trade_sector = TradeSector::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->banking_limits_category = BankingLimitCategory::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->facility_type = FacilityType::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->current_status = Config('srtpl.current_status');
        $this->designation = Designation::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->rating_agency = RatingAgency::select(DB::raw('LOWER(agency_name) as agency_name'), 'id');
        $this->rating = Rating::select(DB::raw('LOWER(rating) as rating'), 'id', 'agency_id', 'remarks');

        $this->authManager = $authManager;
    }

    public function onRow(Row $row)
    {
        // dd($row);
        $country = $this->country->where('name',Str::lower($row['country']))->first();
        $state = $this->state->where('name',Str::lower($row['state']))->first();
        $principle_type = $this->principle_type->where('name',Str::lower($row['principle_type']))->first();
        $jvContractor = Str::lower($row['is_jv']) == 'yes' ? $this->jvContractor->where('company_name',Str::lower($row['contractor']))->first() : [];
        $trade_sector = $this->trade_sector->where('name',Str::lower($row['trade_sector']))->first();
        $banking_limits_category = $this->banking_limits_category->where('name',Str::lower($row['banking_limits_category']))->first();
        $facility_type = $this->facility_type->where('name',Str::lower($row['facility_type']))->first();
        $current_status = in_array($row['obfp_current_status'], $this->current_status) ? $row['obfp_current_status'] : NULL;
        $designation = $this->designation->where('name',Str::lower($row['designation']))->first();
        $rating_agency = $this->rating_agency->where('agency_name', Str::lower($row['agency_name']))->first();
        $rating = $this->rating->where('rating', Str::lower($row['rating']))->where('agency_id', $rating_agency->id)->first();

        $roleId = Role::where('slug', 'contractor')->value('id');
        if(!isset($roleId)){
            return redirect()->route('principle.index')->with('error', 'Role Not Found, Please Check the Role List');
        }
        $loginUser = Sentinel::getUser();
        $user_id = $loginUser ? $loginUser->id : 0;

        $role_details = Role::findOrFail($roleId);
        $role_permissions = $role_details->permissions;
        $this->common = new CommonController();
        $generateOtp = $this->common->generateRandumCodeEmail();
        $userArr = [
            'first_name' => $row['first_name'] ?? NULL,
            'middle_name' => $row['middle_name'] ?? NULL,
            'last_name' => $row['last_name'] ?? NULL,
            'email' => $row['email'] ?? NULL,
            'mobile' => $row['mobile'] ?? NULL,
            'password' => Hash::make($generateOtp),
            'roles_id' => $roleId,
            'created_by' => $user_id,
            'is_active' => 'Yes',
            'permissions' => $role_permissions,
        ];

        $result = $this->authManager->register($userArr, true);
        $user_id = $result->user->id;
        $user = User::findOrFail($user_id);
        $user->update($userArr);
        $result->user->roles()->sync($roleId);

        $principleArr =  [
            'code' => codeGenerator('principles', 7, 'CIN'),
            'registration_no' => $row['registration_no'] ?? NULL,
            'company_name' => $row['company_name'] ?? NULL,
            'address' => $row['address'] ?? NULL,
            'website' => $row['website'] ?? NULL,
            'country_id' => $country->id ?? NULL,
            'state_id' => $state->id ?? NULL,
            'city' => $row['city'] ?? NULL,
            'pincode' => $row['pincode'] ?? NULL,
            'gst_no' => $row['gst_no'] ?? NULL,
            'pan_no' => $row['pan_no'] ?? NULL,
            'user_id' => $user->id,
            'date_of_incorporation' => isset($row['date_of_incorporation']) ? Date::excelToDateTimeObject($row['date_of_incorporation'])->format('Y-m-d') : NULL,
            'principle_type_id' => $principle_type->id ?? 0,
            'is_jv' => $row['is_jv'] ?? NULL,
            'are_you_blacklisted' => $row['are_you_blacklisted'] ?? NULL,
            'is_bank_guarantee_provided' => $row['is_bank_guarantee_provided'] ?? NULL,
            'circumstance_short_notes' => $row['circumstance_short_notes'] ?? NULL,
            'is_action_against_proposer' => $row['is_action_against_proposer'] ?? NULL,
            'action_details' => $row['action_details'] ?? NULL,
            'contractor_failed_project_details' => $row['contractor_failed_project_details'] ?? NULL,
            'completed_rectification_details' => $row['completed_rectification_details'] ?? NULL,
            'performance_security_details' => $row['performance_security_details'] ?? NULL,
            'relevant_other_information' => $row['relevant_other_information'] ?? NULL,
        ];
        $principle = Principle::create($principleArr);

        if(Str::lower($row['is_jv']) == 'yes'){
            $panNo = Principle::where('id', $jvContractor->id)->pluck('pan_no')->first() ?? NULL;
            $principleContractor = [
                'contractor_id' => $jvContractor->id ?? NULL,
                'pan_no' => $panNo,
                'share_holding' => $row['share_holding'] ?? NULL,
            ];
            $principle->contractorItem()->create($principleContractor);
        }

        $principleContactDetails = [
            'contact_person' => $row['contact_person'] ?? NULL,
            'email' => $row['contact_person_email'] ?? NULL,
            'phone_no' => $row['contact_person_phone_no'] ?? NULL,
        ];
        $principle->contactDetail()->create($principleContactDetails);

        $principleTradeSector = [
            'trade_sector_id' => $trade_sector->id ?? NULL,
            'from' => isset($row['from']) ? Date::excelToDateTimeObject($row['from'])->format('Y-m-d') : NULL,
            'till' => isset($row['till']) ? Date::excelToDateTimeObject($row['till'])->format('Y-m-d') : NULL,
            'is_main' => $row['is_main'] ?? NULL,
        ];
        $principle->tradeSector()->create($principleTradeSector);

        $agencyDetails = [
            'agency_id' => $rating_agency->id ?? null,
            'rating_id' => $rating->id ?? null,
            'rating' => $row['rating'] ?? null,
            'remarks' => $rating->remarks ?? null,
        ];
        $principle->agencyRatingDetails()->create($agencyDetails);

        $bankingLimits = [
            'banking_category_id' => $banking_limits_category->id ?? NULL,
            'facility_type_id' => $facility_type->id ?? NULL,
            'sanctioned_amount' => $row['sanctioned_amount'] ?? NULL,
            'bank_name' => $row['bank_name'] ?? NULL,
            'latest_limit_utilized' => $row['latest_limit_utilized'] ?? NULL,
            'unutilized_limit' => $row['unutilized_limit'] ?? NULL,
            'commission_on_pg' => $row['commission_on_pg'] ?? NULL,
            'commission_on_fg' => $row['commission_on_fg'] ?? NULL,
            'margin_collateral' => $row['margin_collateral'] ?? NULL,
            'other_banking_details' => $row['other_banking_details'] ?? NULL,
        ];
        $principle->bankingLimits()->create($bankingLimits);

        $project_start_date = Date::excelToDateTimeObject($row['project_start_date'])->format('Y-m-d');
        $project_end_date = Date::excelToDateTimeObject($row['project_end_date'])->format('Y-m-d');
        $project_tenor = Carbon::parse(strtotime($project_start_date))->diffInDays(Carbon::parse(strtotime($project_end_date)));
        $projectsTrackRecords = [
            'project_name' => $row['project_name'] ?? NULL,
            'project_cost' => $row['project_cost'] ?? NULL,
            'project_description' => $row['project_description'] ?? NULL,
            'project_start_date' => isset($row['project_start_date']) ? $project_start_date : NULL,
            'project_end_date' => isset($row['project_end_date']) ? $project_end_date : NULL,
            'project_tenor' => $project_tenor ?? NULL,
            'bank_guarantees_details' => $row['bank_guarantees_details'] ?? NULL,
            'actual_date_completion' => isset($row['actual_date_completion']) ? Date::excelToDateTimeObject($row['actual_date_completion'])->format('Y-m-d') : NULL,
            'bg_amount' => $row['bg_amount'] ?? NULL,
        ];
        $principle->projectTrackRecords()->create($projectsTrackRecords);

        $obfp_start_date = Date::excelToDateTimeObject($row['obfp_project_start_date'])->format('Y-m-d');
        $obfp_end_date = Date::excelToDateTimeObject($row['obfp_project_end_date'])->format('Y-m-d');
        $obfp_project_tenor = Carbon::parse(strtotime($obfp_start_date))->diffInDays(Carbon::parse(strtotime($obfp_end_date)));
        $orderBookAndFutureProjects = [
            'project_name' => $row['obfp_project_name'] ?? NULL,
            'project_cost' => $row['obfp_project_cost'] ?? NULL,
            'project_description' => $row['obfp_project_description'] ?? NULL,
            'project_start_date' => isset($row['obfp_project_start_date']) ? $obfp_start_date : NULL,
            'project_end_date' => isset($row['obfp_project_end_date']) ? $obfp_end_date : NULL,
            'project_tenor' => $obfp_project_tenor ?? NULL,
            'bank_guarantees_details' => $row['obfp_bank_guarantees_details'] ?? NULL,
            'project_share' => $row['obfp_project_share'] ?? NULL,
            'guarantee_amount' => $row['obfp_guarantee_amount'] ?? NULL,
            'current_status' => $current_status ?? NULL,
        ];
        $principle->orderBookAndFutureProjects()->create($orderBookAndFutureProjects);

        $managementProfiles = [
            'designation' => $designation->id ?? NULL,
            'name' => $row['name'] ?? NULL,
            'qualifications' => $row['qualifications'] ?? NULL,
            'experience' => $row['experience'] ?? NULL,
        ];
        $principle->managementProfiles()->create($managementProfiles);
    }

    public function rules():array
    {
        return[
            "principle_type" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->principle_type->pluck('name')->toArray())) {
                    $onFailure('Principle Type not found in system.');
               }
            }],
            "registration_no" => ["required", new AlphabetsAndNumbersV2],
            "company_name" => ["required", new AlphabetsV1],
            "first_name" => ["required", new AlphabetsV1],
            "middle_name" => ["nullable", new AlphabetsV1],
            "last_name" => ["required", new AlphabetsV1],
            "email" => "required|unique:users,email",
            "mobile" => ["required", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "pincode" => ["required", new PinCode],
            "state" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->state->pluck('name')->toArray())) {
                    $onFailure('State not found in system.');
               }
            }],
            "country" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->country->pluck('name')->toArray())) {
                    $onFailure('Country not found in system.');
               }
            }],
            "pan_no" => ["required_if:country_name,india", "unique:principles,pan_no", new PanNo, "nullable", function($attribute, $value, $onFailure) {
                if(Str::lower($this->isCountryIndia) != 'india') {
                    $onFailure('PanNo is prohibited, unless country is India');
                }
            }],
            "gst_no" => ["required_if:country_name,india", "unique:principles,gst_no", new GstNo, "nullable", function($attribute, $value, $onFailure) {
                if(Str::lower($this->isCountryIndia) != 'india') {
                    $onFailure('GstNo is prohibited, unless country is India');
                }
            }],
            // "date_of_incorporation" => "required|date",
            // "rating" => ["nullable", function($attribute, $value, $onFailure) {
            //     if(!in_array(Str::lower($value), $this->rating->pluck('rating')->toArray())) {
            //         $onFailure('Rating not found in system.');
            //     }
            // }],

            // "agency_name" => ["nullable", function($attribute, $value, $onFailure) {
            //     if(!in_array(Str::lower($value), $this->rating_agency->pluck('agency_name')->toArray())) {
            //         $onFailure('Agency Name not found in system.');
            //     }
            // }],

            "trade_sector" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->trade_sector->pluck('name')->toArray())) {
                    $onFailure('Trade Sector not found in system.');
               }
            }],
            "from" => "required|before_or_equal:today",
            "till" => "nullable|after_or_equal:tradeSector.*.from",

            "website" => "nullable|url",
            "are_you_blacklisted" => "nullable",
            "is_bank_guarantee_provided" => "nullable",
            "circumstance_short_notes" => ["nullable", new AlphabetsAndNumbersV3],
            "is_action_against_proposer" => "nullable",
            "action_details" => ["nullable", new AlphabetsAndNumbersV3],
            "contractor_failed_project_details" => ["nullable", new AlphabetsAndNumbersV3],
            "completed_rectification_details" => ["nullable", new AlphabetsAndNumbersV3],
            "performance_security_details" => ["nullable", new AlphabetsAndNumbersV3],
            "relevant_other_information" => ["nullable", new AlphabetsAndNumbersV3],

            "contractor" => ["required_if:is_jv,Yes", function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->jvContractor->pluck('company_name')->toArray()) && Str::lower($this->isJV) == 'yes') {
                    $onFailure('Contractor not found in system.');
               }
            }],
            "share_holding" => ["required_if:is_jv,Yes", "decimal:0,2", "gte:0.1", "lte:100", "nullable"],

            "contact_person" => ["nullable", new AlphabetsV1],
            "contact_person_email" => "nullable|email",
            "contact_person_phone_no" => ["nullable", new MobileNo],

            // Proposal Banking Limits

            "banking_limits_category" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->banking_limits_category->pluck('name')->toArray())) {
                    $onFailure('Banking Limits Category not found in system.');
               }
            }],
            "facility_type" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->facility_type->pluck('name')->toArray())) {
                    $onFailure('Facility Type not found in system.');
               }
            }],
            "sanctioned_amount" => ["required", new Numbers],
            "bank_name" => ["required", new AlphabetsV1],
            "latest_limit_utilized" => ["required", new Numbers],
            "unutilized_limit" => ["required", new Numbers],
            "commission_on_pg" => ["nullable", new Numbers],
            "commission_on_fg" => ["nullable", new Numbers],
            "margin_collateral" => ["required", new Numbers],
            "other_banking_details" => ["nullable", new AlphabetsAndNumbersV3],

            // Order Book and Future Projects
            "obfp_project_share" => ["nullable", new Numbers],
            "obfp_guarantee_amount" => ["nullable", new Numbers],
            "obfp_current_status" => ["nullable", function($attribute, $value, $onFailure) {
                if (!in_array($value, $this->current_status)) {
                    $onFailure('Current Status not found.');
               }
            }],
            "obfp_project_name" => ["nullable", new AlphabetsV1],
            "obfp_project_cost" => ["nullable", new Numbers],
            "obfp_project_description" => ["nullable", new AlphabetsAndNumbersV3],
            "obfp_project_start_date" => "nullable",
            "obfp_project_end_date" => "nullable",
            "obfp_bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],

            // Project Track Records
            "project_name" => [new AlphabetsV1, "nullable"],
            "project_cost" => [new Numbers, "nullable"],
            "project_start_date" => "nullable",
            "actual_date_completion" => "nullable",
            "bg_amount" => [new Numbers, "nullable"],
            "project_description" => ["nullable", new AlphabetsAndNumbersV3],
            "project_end_date" => "nullable",
            "bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],

            // Management Profiles
            "designation" => ['nullable',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->designation->pluck('name')->toArray())) {
                    $onFailure('Designation not found in system.');
               }
            }],
            "name" =>["nullable", new AlphabetsV1],
            "qualifications" => ["nullable", new AlphabetsV1],
            "experience" => ["nullable", new Numbers],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $this->isCountryIndia = $data['country'];
        $data['country_name'] = $data['country'];
        $this->isJV = $data['is_jv'];
        return $data;
    }

    public function chunkSize(): int
    {
        return 5;
    }
}
