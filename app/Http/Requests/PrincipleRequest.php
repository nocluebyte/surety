<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{
  Country,
  Role,
  Principle,
};
use App\Rules\{
  GstNo,
  PinCode,
  AlphabetsV1,
  AlphabetsAndNumbersV2,
  MobileNo,
  PanNo,
  AlphabetsAndNumbersV3,
  Numbers,
  Remarks,
  PercentageV1,
  DecimalV2,
  MultipleFile,
  AlphabetsAndNumbersV8,
  AlphabetsAndNumbersV9,
  PinCodeV2,
  ValidateExtensions,
};
use Illuminate\Support\Str;
use DB;

class PrincipleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd($this->all());
        $user_id = $this->get('user_id');
        $principle_id = $this->get('id');

        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];
        return [
            "principle_type_id" => "required",
            "registration_no" => ["required_if:venture_type,Stand Alone", new AlphabetsAndNumbersV2, "nullable"],
            "company_name" => ["required", new AlphabetsAndNumbersV8],
            // "first_name" => ["required", new AlphabetsV1],
            // "middle_name" => ["nullable", new AlphabetsV1],
            // "last_name" => ["required", new AlphabetsV1],
            "email" => "required|unique:users,email,{$user_id},id,deleted_at,NULL",
            "mobile" => ["required", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "pincode" => $pincodeValidation,
            "state_id" => "required",
            "country_id" => "required",
            "pan_no" => ["required_if:country_name,india", "unique:principles,pan_no,{$principle_id},id,deleted_at,NULL", new PanNo, "nullable"],
            "gst_no" => ["required_if:venture_type,Stand Alone", "unique:principles,gst_no,{$principle_id},id,deleted_at,NULL", new GstNo, "nullable"],
            "date_of_incorporation" => "required|date",
            "entity_type_id" => "required",
            "staff_strength" => ["nullable", new Numbers],
            "tradeSector.*.trade_sector" => "required",
            "tradeSector.*.from" => "required|date|before_or_equal:today",
            "tradeSector.*.till" => "nullable|date|after_or_equal:tradeSector.*.from",
            // "inception_date" => "required|date",
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

            "venture_type" => "required",
            "contractorDetails.*.contractor_id" => "required_if:venture_type,JV,SPV",
            "contractorDetails.*.contractor_pan_no" => ["nullable", new PanNo],
            "contractorDetails.*.share_holding" => ["required_if:venture_type,JV,SPV", new PercentageV1, "nullable"],

            "contactDetail.*.contact_person" => ["nullable", new AlphabetsV1],
            "contactDetail.*.email" => "nullable|email",
            "contactDetail.*.phone_no" => ["nullable", new MobileNo],

            "unique_mobile" => "boolean:false",

            "company_details.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "company_technical_details.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "company_presentation.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "certificate_of_incorporation.*" => [
              "required_if:id,NULL",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "memorandum_and_articles.*" => [
              "required_if:id,NULL",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "gst_certificate.*" => [
              "required_if:venture_type,Stand Alone",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              "nullable",
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "company_pan_no.*" => [
              "required_if:venture_type,Stand Alone",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              "nullable",
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "last_three_years_itr.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],

            "attachment_count.company_details_count" => "lte:5",
            "attachment_count.company_technical_details_count" => "lte:5",
            "attachment_count.company_presentation_count" => "lte:5",
            "attachment_count.certificate_of_incorporation_count" => "lte:5|not_in:0",
            "attachment_count.memorandum_and_articles_count" => "lte:5|not_in:0",
            "attachment_count.gst_certificate_count" => "lte:5",
            "attachment_count.company_pan_no_count" => "lte:5",
            "attachment_count.last_three_years_itr_count" => "lte:5",

            // Proposal Banking Limits

            "pbl_items.*.banking_category_id" => "nullable",
            "pbl_items.*.facility_type_id" => "nullable",
            "pbl_items.*.sanctioned_amount" => ["nullable", new Numbers],
            "pbl_items.*.bank_name" => ["nullable", new AlphabetsV1],
            "pbl_items.*.latest_limit_utilized" => ["nullable", new Numbers],
            "pbl_items.*.unutilized_limit" => ["nullable", new Numbers],
            "pbl_items.*.commission_on_pg" => ["nullable", new Numbers],
            "pbl_items.*.commission_on_fg" => ["nullable", new Numbers],
            "pbl_items.*.margin_collateral" => ["nullable", new Numbers],
            "pbl_items.*.other_banking_details" => ["nullable", new AlphabetsAndNumbersV3],
            "pbl_items.*.banking_limits_attachment.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],

            // Order Book and Future Projects

            "obfp_items.*.project_share" => ["nullable", new Numbers],
            "obfp_items.*.guarantee_amount" => ["nullable", new Numbers],
            "obfp_items.*.current_status" => "nullable",
            "obfp_items.*.project_name" => ["nullable", new AlphabetsAndNumbersV8],
            "obfp_items.*.project_cost" => ["nullable", new Numbers],
            "obfp_items.*.project_description" => ["nullable", new Remarks],
            "obfp_items.*.project_start_date" => "nullable",
            "obfp_items.*.project_end_date" => "nullable",
            "obfp_items.*.project_tenor" => ["nullable", new Numbers],
            "obfp_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
            "obfp_items.*.order_book_and_future_projects_attachment.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],

            // Project Track Records

            "ptr_items.*.project_name" => [new AlphabetsAndNumbersV8, "nullable"],
            "ptr_items.*.project_cost" => [new Numbers, "nullable"],
            "ptr_items.*.project_tenor" => [new Numbers, "nullable"],
            "ptr_items.*.project_start_date" => "nullable",
            "ptr_items.*.actual_date_completion" => "nullable",
            "ptr_items.*.bg_amount" => [new Numbers, "nullable"],
            "ptr_items.*.project_description" => ["nullable", new Remarks],
            "ptr_items.*.project_end_date" => "nullable",
            "ptr_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
            "ptr_items.*.project_track_records_attachment.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],

            // Management Profiles

            "mp_items.*.designation" => "nullable",
            "mp_items.*.name" =>["nullable", new AlphabetsV1],
            "mp_items.*.qualifications" => ["nullable", new AlphabetsAndNumbersV9],
            "mp_items.*.experience" => ["nullable", new DecimalV2],
            "mp_items.*.management_profiles_attachment.*" => [
              "nullable",
              "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
              new MultipleFile(52428800, 5),
              new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
        ];
    }

    public function prepareForValidation(){

      $requestData = request()->all();

      $country_id = request()->country_id;
      if($country_id) {
          $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
      }
      $country_name = Str::lower($name);

      $id = request()->id;
      $roleId = Role::where('slug', 'contractor')->value('id');
      $value  = request()->mobile;
      $checkField = '';
      if($value != ''){
        $checkField = DB::table('users')
        ->where('mobile',$value)
        ->where('roles_id', $roleId)
        ->whereNull('deleted_at')
        ->when($id, function ($query) use ($id) {
            $query->where('id', '!=', $id);
        })
        ->exists();
      }
      $uniqueMobileNo = $checkField == true && $id == null ? "exists" : false;

      // if($uniqueMobileNo){
      //     $this->merge(['unique_mobile' => $uniqueMobileNo]);
      // }
      // dd($uniqueMobileNo);

      $principleDocuments = [
        'company_details',
        'company_technical_details',
        'company_presentation',
        'certificate_of_incorporation',
        'memorandum_and_articles',
        'gst_certificate',
        'company_pan_no',
        'last_three_years_itr',
      ];

      $attachmentCount = [];

      $principle = Principle::find($this->get('id'));

      foreach ($principleDocuments as $item) {
        if (isset($requestData[$item]) && !empty($requestData[$item])) {
            $selected[$item . '_count'] = count($requestData[$item]);
        } else {
            $selected[$item . '_count'] = 0;
        }

        if ($principle && isset($principle->dMS)) {
            $attachmentCount[$item . '_count'] = $principle->dMS->where('attachment_type', $item)->count() + $selected[$item . '_count'];
        } else {
            $attachmentCount[$item . '_count'] = $selected[$item . '_count'];
        }
      }

      $this->merge([
        'country_name'=>$country_name,
        'unique_mobile' => $uniqueMobileNo,
        'attachment_count' => $attachmentCount,
      ]);
    }

    public function messages(){
        return [
            "tradeSector.*.from.date" => "Invalid Date Format",
            "tradeSector.*.from.before_or_equal" => "The Trade Sector 'From Date' must be a date before or equal to Today's Date.",
            "tradeSector.*.till.date" => "Invalid Date Format",
            "tradeSector.*.till.after_or_equal" => "The Trade Sector 'Till Date' must be a date after or equal to 'From Date'.",
            "inception_date.after_or_equal" => "'Inception Date' must be a date after or equal to 'Date of Incorporation'.",

            "contractorDetails.*.contractor_id" => "Principle/Contractor is required",
            "contractorDetails.*.contractor_pan_no" => "The field must be a valid PAN number. eg.(ABCDE6789S)",
            "contractorDetails.*.share_holding" => "Please enter a valid Number [0-100].",
            "unique_mobile" => "The Phone No. has already been taken.",

            "contractorDetails.*.contractor_pan_no.prohibited_if" => "Contractor Pan No. field prohibited if Is JV is No",
            "contractorDetails.*.contractor_id.prohibited_if" => "Contractor ID field prohibited if Is JV is No",
            "contractorDetails.*.share_holding.prohibited_if" => "Contractor Share Holding field prohibited if Is JV is No",

            "attachment_count.company_details_count.lte" => "The number of files for Company Details must not exceed (5)",
            "attachment_count.company_technical_details_count.lte" => "The number of files for Company Technical Details must not exceed (5)",
            "attachment_count.company_presentation_count.lte" => "The number of files for Company Presentation must not exceed (5)",
            "attachment_count.certificate_of_incorporation_count.lte" => "The number of files for Certificate of Incorporation must not exceed (5)",
            "attachment_count.memorandum_and_articles_count.lte" => "The number of files for Memorandum and Articles must not exceed (5)",
            "attachment_count.gst_certificate_count.lte" => "The number of files for GST Certificate must not exceed (5)",
            "attachment_count.company_pan_no_count.lte" => "The number of files for Company PAN No must not exceed (5)",
            "attachment_count.last_three_years_itr_count.lte" => "The number of files for Last 3 years ITR must not exceed (5)",

            "attachment_count.certificate_of_incorporation_count.not_in" => "Certificate of Incorporation field is required.",
            "attachment_count.memorandum_and_articles_count.not_in" => "Memorandum and Articles field is required.",
            "attachment_count.gst_certificate_count.not_in" => "GST Certificate field is required.",
            "attachment_count.company_pan_no_count.not_in" => "Company PAN No file upload field is required.",

            "gst_no.prohibited_unless" => "The gst no field is prohibited unless country name is in india.",

              // Proposal Banking Limits

              "pbl_items.*.banking_category_id" => "Banking Limits -> Banking Category required",
              "pbl_items.*.facility_type_id" => "Banking Limits -> Facility Type required",
              "pbl_items.*.sanctioned_amount.required" => "Banking Limits -> Sanctioned Amount required",
              "pbl_items.*.bank_name.required" => "Banking Limits -> Bank Name required",
              "pbl_items.*.latest_limit_utilized.required" => "Banking Limits -> Latest Limit Utilized required",
              "pbl_items.*.unutilized_limit.required" => "Banking Limits -> Unutilized Limit required",
              "pbl_items.*.margin_collateral.required" => "Banking Limits -> Margin Collateral required",

              // Order Book and Future Projects

              // "obfp_items.*.project_scope" => "Order Book and Future Projects -> Project Scope required",
              // "obfp_items.*.principal_name" => "Order Book and Future Projects -> Principal Name required",
              // "obfp_items.*.project_location" => "Order Book and Future Projects -> Project Location required",
              // "obfp_items.*.type_of_project" => "Order Book and Future Projects -> Project Type required",
              // "obfp_items.*.contract_value" => "Order Book and Future Projects -> Contract Value required",
              // "obfp_items.*.anticipated_date" => "Order Book and Future Projects -> Anticipated Date required",
              // "obfp_items.*.tenure" => "Order Book and Future Projects -> Tenure required",
              // "obfp_items.*.project_share" => "Order Book and Future Projects -> Project Share required",
              // "obfp_items.*.guarantee_amount" => "Order Book and Future Projects -> Guarantee Amount required",
              // "obfp_items.*.current_status" => "Order Book and Future Projects -> Current Status required",
  
              // Project Track Records
  
              // "ptr_items.*.project_name" => "Project Track Records -> Project Name required",
              // "ptr_items.*.description" => "Project Track Records -> Description required",
              // "ptr_items.*.project_cost" => "Project Track Records -> Project Cost required",
              // "ptr_items.*.project_tenor" => "Project Track Records -> Project Tenor required",
              // "ptr_items.*.project_start_date" => "Project Track Records -> Project Start Date required",
              // "ptr_items.*.principal_name" => "Project Track Records -> Principal Name required",
              // "ptr_items.*.estimated_date_of_completion" => "Project Track Records -> Estimated Date of Completion required",
              // "ptr_items.*.estimated_date_of_completion.after" => "Project Track Records -> Estimated Date of Completion must be greater than Project Start Date",
              // "ptr_items.*.type_of_project_track" => "Project Track Records -> Type of Project Track required",
              // "ptr_items.*.project_share_track" => "Project Track Records -> Project Share Track required",
              // "ptr_items.*.actual_date_completion" => "Project Track Records -> Actual Date of Completion required",
              // "ptr_items.*.actual_date_completion.after" => "Project Track Records -> Actual Date of Completion must be greater than Project Start Date",
              // "ptr_items.*.amount_margin" => "Project Track Records -> Amount of Margin required",
              // "ptr_items.*.completion_status" => "Project Track Records -> Completion Status required",
              // "ptr_items.*.bg_amount" => "Project Track Records -> Amount of BG Invoked required",
  
              // Management Profiles
  
              // "mp_items.*.designation" => "Management Profiles -> Designation required",
              // "mp_items.*.name" => "Management Profiles -> Name required",
              // "mp_items.*.qualifications" => "Management Profiles -> Qualifications required",
              // "mp_items.*.experience" => "Management Profiles -> Experience required",
              // "bond_start_date" => "Bond start date required",
              // "bond_end_date" => "Bond end date required"
        ];
    }
}
