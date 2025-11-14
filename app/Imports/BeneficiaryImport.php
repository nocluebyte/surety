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
    Beneficiary,
    TradeSector,
    EstablishmentType,
    MinistryType,
    User,
    Role,
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
use Sentinel;

class BeneficiaryImport implements WithHeadingRow ,WithValidation,SkipsOnFailure  ,OnEachRow,WithChunkReading
{
    use SkipsFailures,Importable;
    private $country;
    private $state;
    private $isCountryIndia;
    private $beneficiaryType;
    public function __construct($authManager)
    {
        $this->country = Country::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->state = State::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->trade_sector = TradeSector::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->establishment_type = EstablishmentType::select(DB::raw('LOWER(name) as name'),'id')->get();
        $this->ministry_type = MinistryType::select(DB::raw('LOWER(name) as name'),'id')->get();

        $this->authManager = $authManager;
    }

    public function onRow(Row $row)
    {
        $country = $this->country->where('name',Str::lower($row['country']))->first();
        $state = $this->state->where('name',Str::lower($row['state']))->first();
        $trade_sector = $this->trade_sector->where('name',Str::lower($row['trade_sector']))->first();
        $establishment_type = $this->establishment_type->where('name',Str::lower($row['establishment_type']))->first();
        $ministry_type = $this->ministry_type->where('name',Str::lower($row['ministry_type']))->first();

        $roleId = Role::where('slug', 'beneficiary')->value('id');
        if(!isset($roleId)){
            return redirect()->route('beneficiary.index')->with('error', 'Role Not Found, Please Check the Role List');
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

        $beneficiary =  new Beneficiary([
            'code' => codeGenerator('beneficiaries', 7, 'BIN'),
            'registration_no' => $row['registration_no'] ?? NULL,
            'company_name' => $row['company_name'] ?? NULL,
            'address' => $row['address'] ?? NULL,
            'state_id' => $state->id ?? NULL,
            'country_id' => $country->id ?? NULL,
            'city' => $row['city'] ?? NULL,
            'gst_no' => $row['gst_no'] ?? NULL,
            'pan_no' => $row['pan_no'] ?? NULL,
            'beneficiary_type' => $row['beneficiary_type'] ?? NULL,
            'establishment_type_id' => $establishment_type->id ?? NULL,
            'ministry_type_id' => $ministry_type->id ?? NULL,
            'bond_wording' => $row['bond_wording'] ?? NULL,
            'website'=>$row['website'] ?? NULL,
            'pincode'=>$row['pincode'] ?? NULL,
            'user_id' => $user->id,
        ]);
        $beneficiary->save();

        $beneficiaryTradeSector = [
            'trade_sector_id' => $trade_sector->id ?? NULL,
            'from' => isset($row['from']) ? Date::excelToDateTimeObject($row['from'])->format('Y-m-d') : NULL,
            'till' => isset($row['till']) ? Date::excelToDateTimeObject($row['till'])->format('Y-m-d') : NULL,
            'is_main' => $row['is_main'] ?? NULL,
        ];
        $beneficiary->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSector);
    }

    public function rules():array
    {
        return[
            "registration_no" => ["required", new AlphabetsAndNumbersV2],
            "company_name" => ["required", new AlphabetsV1],
            "email" => "nullable|unique:users,email",
            "mobile" => ["nullable", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            'state' => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->state->pluck('name')->toArray())) {
                    $onFailure('State not found in system.');
               }
            }],
            'country' => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->country->pluck('name')->toArray())) {
                    $onFailure('Country not found in system.');
               }
            }],
            "pan_no" => ["required_if:country_name,India", "unique:beneficiaries,pan_no", new PanNo, "nullable", function($attribute, $value, $onFailure) {
                if(Str::lower($this->isCountryIndia) != 'india') {
                    $onFailure('PanNo is prohibited, unless country is India');
                }
            }],
            "gst_no" => ["required_if:country_name,India", "unique:beneficiaries,gst_no", new GstNo, "nullable", function($attribute, $value, $onFailure) {
                if(Str::lower($this->isCountryIndia) != 'india') {
                    $onFailure('GstNo is prohibited, unless country is India');
                }
            }],
            "beneficiary_type" => "required",
            "establishment_type" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->establishment_type->pluck('name')->toArray())) {
                    $onFailure('Establishment Type not found in system.');
               }
            }],
            "ministry_type" => ["required_if:beneficiary_type,Government", function($attribute, $value, $onFailure) {
                    if (!in_array(Str::lower($value),$this->ministry_type->pluck('name')->toArray())) {
                        $onFailure('Ministry Type not found in system.');
                    }
                    if(Str::lower($this->beneficiaryType) != 'government') {
                        $onFailure('Ministry Type is prohibited, unless Beneficiary Type is Government');
                    }
                }
            ],
            "bond_wording" => ["nullable", new AlphabetsAndNumbersV3],
            "website" => "nullable|url",

            "trade_sector" => ['required',function($attribute, $value, $onFailure) {
                if (!in_array(Str::lower($value),$this->trade_sector->pluck('name')->toArray())) {
                    $onFailure('Trade Sector not found in system.');
               }
            }],
            "from" => "required|before_or_equal:today",
            "till" => "nullable|after_or_equal:from",
            "pincode" => ["required", new PinCode],
        ];
    }

    public function prepareForValidation($data, $index)
    {
        $this->isCountryIndia = $data['country'];
        $data['country_name'] = $data['country'];
        $this->beneficiaryType = $data['beneficiary_type'];
        return $data;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
