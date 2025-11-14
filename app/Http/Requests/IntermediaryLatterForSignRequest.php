<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};

class IntermediaryLatterForSignRequest extends FormRequest
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
            "proposal_id"=>"required",
            "indemnity_letter_type" => "required|in:Manually,Leegality",
            "indemnity_letter_document" => ['nullable', 'file', 'mimes:pdf', new MultipleFile(2097152, 1), new ValidateExtensions(['pdf'])],
            "indemnity_signing_through" => "nullable|required_if:indemnity_letter_type,Leegality|in:Phone,Email,Aadhar"
        ];
    }
}
