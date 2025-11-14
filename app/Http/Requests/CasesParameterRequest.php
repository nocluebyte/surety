<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Numbers;

class CasesParameterRequest extends FormRequest
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
            'bond.*.bond_type_id'=>'required',
            'bond.*.proposed_cap'=>['required','gte:bond.*.utilized_cap',new Numbers],
            'bond.*.valid_till'=>'required|date',

        ];
    }

    public function messages(): array{
        return [
            'underwriter_id.required'=>' Please assign underwriter to take any action.'
        ];
    }
}
