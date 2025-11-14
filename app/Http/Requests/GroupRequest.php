<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupRequest extends FormRequest
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

    public function rules()
    {
        return [
            "contractor_id" => "required_without:id",

            "contractorids.*.type" => "required",
            "contractorids.*.from_date" => "required|date",
            "contractorids.*.till_date" => "nullable|date|after_or_equal:contractorids.*.from_date",
        ];
    }

    public function messages()
    {
        return [
            "contractorids.*.type" => "Contractor type required",
            "contractorids.*.from_date" => "Invalid date format",
            "contractorids.*.till_date.date" => "Invalid date format",
            "contractorids.*.till_date.after_or_equal" =>  "The 'Till date' must be a date after or equal to 'From date'.",
        ];
    }
}
