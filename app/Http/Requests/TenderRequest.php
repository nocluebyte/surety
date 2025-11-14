<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Tender;
use Illuminate\Support\Str;
use App\Rules\{
    Numbers,
    AlphabetsAndNumbersV5,
    PanNo,
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV3,
    MultipleFile,
    AlphabetsAndNumbersV8,
    ValidateExtensions,
    Remarks,
};

class TenderRequest extends FormRequest
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
        $tender_id = $this->get("id");

        return [
            "code" => "required",
            "tender_id" => ["required", "unique:tenders,tender_id,{$tender_id},id,deleted_at,NULL", new AlphabetsAndNumbersV5],
            // "tender_reference_no" => ["required", "unique:tenders,tender_reference_no,{$tender_id},id,deleted_at,NULL", new AlphabetsAndNumbersV5],
            "beneficiary_id" => "required",
            "tender_header" => ["required", new AlphabetsAndNumbersV8],
            "location" => ["required", new AlphabetsV1],
            "project_type" => "nullable",
            // "phone_no" => ["required", new MobileNo],
            //"pan_no" => ["required_if:country_name,india", "unique:tenders,pan_no,{$tender_id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new PanNo, "nullable"],
            // "first_name" => ["required", new AlphabetsV1],
            // "middle_name" => ["nullable", new AlphabetsV1],
            // "last_name" => ["required", new AlphabetsV1],
            // "email" => "required|email|unique:tenders,email,{$tender_id},id,deleted_at,NULL",
            // "address" => ["required", new AlphabetsAndNumbersV3],
            // "country_id" => "required",
            // "state_id" => "required",
            // "city" => ["required", new AlphabetsV1],
            "contract_value" => ["required", new Numbers],
            // "period_of_contract" => ["required", new Numbers, 'gt:1', 'lte:999'],
            "period_of_contract" => ["required", new Numbers],
            "bond_value" => ["required", new Numbers],
            "bond_type_id" => "required",
            "tender_description" => "required",
            "rfp_date" => "required|date",
            "rfp_attachment.*" => [
                "required_if:id,NULL", 
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", 
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            /*"bond_start_date" => "required|date",
            "bond_end_date" => "required|date|after_or_equal:bond_start_date",
            "period_of_bond" => "required",*/
            "project_description" => "required",
            "type_of_contracting" => "required",
            "rfp_attachment_count" => "lte:5",

            "project_details_id" => "required",
            "pd_beneficiary" => "required",
            "pd_project_name" => ["required", new AlphabetsAndNumbersV8],
            "pd_project_description" => ["required", new Remarks],
            "pd_project_value" => ["required", new Numbers],
            "pd_type_of_project" => "required",
            "pd_project_start_date" => "required",
            "pd_project_end_date" => "required",
            "pd_period_of_project" => "required",
        ];
    }

    public function prepareForValidation(){

        // $country_id = request()->country_id;
        // if($country_id) {
        //     $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
        // }
        // $country_name = Str::lower($name);

        $tender_description = strip_tags(request()->tender_description);
        $project_description = strip_tags(request()->project_description);

        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['rfp_attachment'])) {
            $newDoc = count($requestData['rfp_attachment']);
        }

        $tender_attachment = Tender::find($this->get('id'));

        $preDoc = 0;
        if(isset($tender_attachment->dMS)) {
            $preDoc = $tender_attachment->dMS->countBy('attachment_type')->first();
        }

        $docCount = $newDoc + $preDoc;
        $this->merge([
            'tender_description' => $tender_description,
            'project_description' => $project_description,
            'rfp_attachment_count' => $docCount,
        ]);
    }

    public function messages(): array
    {
        return [
            "bond_start_date" => "Invalid Date Format",
            "bond_end_date.date" => "Invalid Date Format",
            "bond_end_date.after_or_equal" => "Bond Start Date must be a date after or equal to 'Bond End Date'.",
            "rfp_attachment.max" => "File size must be less than 10 MB",
            "pan_no.required_if" => "The Pan No. is required when selected country is India.",
            "pan_no.prohibited_unless" => "The pan no field is prohibited unless country name is India",
            "rfp_attachment_count.lte" => "The number of files for RFP Attachment must not exceed (5)",
        ];
    }
}
