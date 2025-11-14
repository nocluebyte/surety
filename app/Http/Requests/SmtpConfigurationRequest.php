<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SmtpConfigurationRequest extends FormRequest
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
                Rule::unique('smtp_configurations','module_name')->where('deleted_at',NULL)->ignore($id),
            ],*/
            'host_name' => "required",
            'username' => "required|email",
            'password' => "required",
            'from_name' => "required",
            'port' => "required",
            'driver' => "required",
            'encryption' => "required",
            // 'subject' => "required",
            // 'message_body' => "required",
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
