<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};

class BondCancellationRequest extends FormRequest
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
            "bond_number" => "nullable",
            "contractor_id" => "required",
            "beneficiary_id" => "required",
            "project_details_id" => "required",
            "tender_id" => "required",
            "bond_type_id" => "required",
            "bond_start_date" => "required",
            "bond_end_date" => "required",
            "bond_conditionality" => "required",
            "premium_amount" => "required",
            "cancellation_date" => "required",
            "bond_cancellation_type" => "required",
            "pre_project_remarks" => "required_if:bond_cancellation_type,pre_project",
            "mid_project_remarks" => "required_if:bond_cancellation_type,mid_project",
            "any_other_type_remarks" => "required_if:bond_cancellation_type,any_other_type",
            "remarks" => "required",
            "is_refund" => "required",
            "refund_remarks" => "required_if:is_refund,Yes",
            "is_original_bond_received" => "required",
            "is_confirming_foreclosure" => "required",
            "is_any_other_proof" => "required",
            "bond_cancellation_attachment.*" => ["required_if:id,NULL", "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", new MultipleFile(52428800, 5), new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'])],
            "original_bond_received_attachment.*" => ["required_if:is_original_bond_received,Yes", "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", new MultipleFile(52428800, 5), new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'])],
            "confirming_foreclosure_attachment.*" => ["required_if:is_confirming_foreclosure,Yes", "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", new MultipleFile(52428800, 5), new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'])],
            "any_other_proof_attachment.*" => ["required_if:is_any_other_proof,Yes", "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", new MultipleFile(52428800, 5), new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'])],

            "bond_cancellation_attachment_count" => "lte:5",
            "original_bond_received_attachment_count" => "lte:5",
            "confirming_foreclosure_attachment_count" => "lte:5",
            "any_other_proof_attachment_count" => "lte:5",
        ];
    }

    public function prepareForValidation(){
        $requestData = request()->all();

        $this->merge([
            'bond_cancellation_attachment_count' => isset($requestData['bond_cancellation_attachment']) ? count($requestData['bond_cancellation_attachment']) : 0,
            'original_bond_received_attachment_count' => isset($requestData['original_bond_received_attachment']) ? count($requestData['original_bond_received_attachment']) : 0,
            'confirming_foreclosure_attachment_count' => isset($requestData['confirming_foreclosure_attachment']) ? count($requestData['confirming_foreclosure_attachment']) : 0,
            'any_other_proof_attachment_count' => isset($requestData['any_other_proof_attachment']) ? count($requestData['any_other_proof_attachment']) : 0,
        ]);
    }

    public function messages(): array
    {
        return [
            "proof_of_foreclosure_count.lte" => "The number of files for Proof of ForeClosure must not exceed (5)",
            "original_bond_received_attachment_count.lte" => "The number of files for Original Bond Received Attachment must not exceed (5)",
            "confirming_foreclosure_attachment_count.lte" => "The number of files for Confirming ForeClosure Attachment must not exceed (5)",
            "any_other_proof_attachment_count.lte" => "The number of files for Any Other Proof Attachment must not exceed (5)",
        ];
    }
}
