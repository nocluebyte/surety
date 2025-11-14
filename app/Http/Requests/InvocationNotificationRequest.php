<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{  
    AlphabetsAndNumbersV5,    
    Numbers,
    AlphabetsAndNumbersV2,  
    AlphabetsAndNumbersV3, 
    MultipleFile,
    Remarks,
    LandLine,
    MobileNo,
    ValidateExtensions,
};


class InvocationNotificationRequest extends FormRequest
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
        return [
            "bond_number" => "required",
            'invocation_date' => 'required',
            "invocation_amount" => ["required", new Numbers],
            'invocation_ext' => 'required',
            'officer_name' => ['required', new Remarks],
            'officer_designation' => ['required', new Remarks],
            'officer_email' => 'required',
            'officer_mobile' => ['nullable', new MobileNo],
            'officer_land_line' => ['nullable', new LandLine],
            'incharge_name' => ['nullable', new Remarks],
            'incharge_designation' => ['nullable', new Remarks],
            'incharge_mobile' => ['nullable', new MobileNo],
            'incharge_land_line' => ['nullable', new LandLine],
            'office_branch' => ['required', new Remarks],
            'invocation_notification_attachment.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            'office_address' => ['required', new Remarks],
            'reason_for_invocation' => ['required', new Remarks],
            'remark' => ["nullable", new Remarks],
            'notice_attachment.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],            
            'contract_agreement.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx']),
            ],
            'beneficiary_communication_attachment.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx']),
            ],
            'legal_documents.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx']),
            ],
            'any_other_documents.*' => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx']),
            ],

            'invocation_notification_attachment_count' => 'lte:5',
            'notice_attachment_count' => 'lte:5',
            'contract_agreement_count' => 'lte:5',
            'beneficiary_communication_attachment_count' => 'lte:5',
            'legal_documents_count' => 'lte:5',
            'any_other_documents_count' => 'lte:5',
        ];
    }

    public function prepareForValidation(){
        $requestData = request()->all();

        $this->merge([
            'invocation_notification_attachment_count' => isset($requestData['invocation_notification_attachment']) ? count($requestData['invocation_notification_attachment']) : 0,

            'notice_attachment_count' => isset($requestData['notice_attachment']) ? count($requestData['notice_attachment']) : 0,

            'contract_agreement_count' => isset($requestData['contract_agreement']) ? count($requestData['contract_agreement']) : 0,

            'beneficiary_communication_attachment_count' => isset($requestData['beneficiary_communication_attachment']) ? count($requestData['beneficiary_communication_attachment']) : 0,

            'legal_documents_count' => isset($requestData['legal_documents']) ? count($requestData['legal_documents']) : 0,

            'any_other_documents_count' => isset($requestData['any_other_documents']) ? count($requestData['any_other_documents']) : 0,
        ]);
    }

    public function messages(): array
    {
        return [
            "invocation_notification_attachment_count.lte" => "The number of files for Invocation Notification must not exceed (5)",
            "notice_attachment_count.lte" => "The number of files for Notice Attachment must not exceed (5)",
            "contract_agreement_count.lte" => "The number of files for Contract Agreement must not exceed (5)",
            "beneficiary_communication_attachment_count.lte" => "The number of files for Beneficiary Communication Attachment must not exceed (5)",
            "legal_documents_count.lte" => "The number of files for Legal Documents must not exceed (5)",
            "any_other_documents_count.lte" => "The number of files for Any Other Documents must not exceed (5)",
            "bond_number" => "Add Bond Number in Bond Issued Tab first.",
        ];
    }
}
