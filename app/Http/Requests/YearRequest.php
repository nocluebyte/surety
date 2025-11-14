<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class YearRequest extends FormRequest
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
        $id  = $this->get('id');
        return [
            'yearname' => [
                'required',
                Rule::unique('years')->whereNull('deleted_at')->ignore($id),
                'regex:/^[0-9]{4}-[0-9]{2}$/'
            ],
            'is_default' => 'required',
            'is_displayed' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',

        ];

    }

    public function messages()
    {
        return [
            'yearname.regex' => 'Invalid year format (eg. 2024-25)',
            'yearname.unique' => 'Year name has already been taken.',
            'to_date' => "The 'To date' must be a date after or equal to 'From date'."
        ];
    }
}
