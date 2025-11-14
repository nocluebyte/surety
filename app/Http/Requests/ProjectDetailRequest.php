<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    AlphabetsAndNumbersV3,
    Numbers,
    AlphabetsAndNumbersV8,
    Remarks,
};

class ProjectDetailRequest extends FormRequest
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
        // dd(request()->all());
        return [
            "code" => "required",
            "beneficiary_id" => "required",
            "project_name" => ["required", new AlphabetsAndNumbersV8],
            "project_description" => ["required", new Remarks],
            "project_value" => ["required", new Numbers],
            "type_of_project" => "required",
            "project_start_date" => "required|before_or_equal:project_end_date",
            "project_end_date" => "required|after_or_equal:project_start_date",
            "period_of_project" => ["required", new Numbers],
        ];
    }
}
