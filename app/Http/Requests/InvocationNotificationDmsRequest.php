<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvocationNotificationDmsRequest extends FormRequest
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
            'id'=>'required',
            'final_submission'=>'required',
            'document_type_id'=>'required',
            'file_source_id'=>'required',
            'attachment.*'=>'mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls|max:2048',
        ];
    }
}
