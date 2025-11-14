<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\{
    AlphabetsV1,
    ValidateExtensions,
};

class MailTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id');
        return [     
            /*'module_name' => [
                'required',
                Rule::unique('mail_templates','module_name')->where('deleted_at',NULL)->ignore($id),
            ],*/
            'smtp_id' => "required",
            'subject' => ["required", new AlphabetsV1],
            'message_body' => "required",
            "attachment" => [
                "nullable",
                "file", "mimes:xls,xlsx,doc,docs,pdf",
                "max:10240",
                new ValidateExtensions(['xls', 'xlsx', 'doc', 'docx', 'pdf']),
            ],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "attachment.max" => "The attachment must not be greater than 10 MB.",
        ];
    }
}
