<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};

class CasesDmsAttachmentRequest extends FormRequest
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
            'final_submission'=>'required',
            'document_type_id'=>'required',
            'file_source_id'=>'required',
            'attachment.*'=>[
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            'id'=>'required',
            'document_specific_type' => "required_if:id,NULL|in:Contractor,Project",
        ];
    }

    public function messages()
    {
        return [
            'attachment.*' => 'The attachment must be a file of type: pdf, xlsx, xls, doc, docx, png, jpg, jpeg.',
        ];
    }
}
