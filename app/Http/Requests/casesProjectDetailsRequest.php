<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsAndNumbersV3
};

class casesProjectDetailsRequest extends FormRequest
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
            'underwriter_id'=>'required',
            'project_details_current_status_of_the_project'=>['required',new AlphabetsAndNumbersV3],
            'project_details_any_updates'=>['required',new AlphabetsAndNumbersV3]
        ];
    }

    public function messages(): array
    {
        return [
            'underwriter_id.required'=>'Please assign underwriter to take any action',
        ];
    } 
}
