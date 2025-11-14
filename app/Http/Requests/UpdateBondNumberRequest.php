<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    MultipleFile,
    Remarks,
    ValidateExtensions,
};

class UpdateBondNumberRequest extends FormRequest
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
            "bond_issue_id" => "required",
            "proposal_id" => "required",
            "bond_number" => ['nullable', new Remarks],
            "bond_stamp_paper.*" => [
                "nullable", 
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", 
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
        ];
    }
}
