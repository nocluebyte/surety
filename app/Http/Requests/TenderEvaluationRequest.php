<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\{
    Numbers,
    AlphabetsAndNumbersV1,
    Remarks,
};

class TenderEvaluationRequest extends FormRequest
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
        $proposal_id = $this->get('proposal_id');
        $id = $this->get('id');
        return [
            "proposal_code" => "required",
            "contractor_code" => "required",
            "tender_id" => "required",
            "project_description" => "required",
            "beneficiary" => "required",
            "project_value" => ["required", new Numbers],
            "bond_value" => ["required", new Numbers],
            "bond_start_date" => "required",
            "bond_end_date" => "required",
            "bond_period" => "required",
            "name" => "required_if:joint_venture,Yes",
            'other_work_type' => Rule::requiredIf(function ()  {
                $work_type = request()->work_type ?? [];
                return (in_array('-1', $work_type));
            }),
            'locations.*.state_id'=>"required",
            'locations.*.location'=>["required", new AlphabetsAndNumbersV1],
            'attachment'=>($id > 0) ? 'max:20971520|mimes:xls,xlsx,doc,docx,pdf,jpg,jpeg,png' : 'required|max:20971520|mimes:xls,xlsx,doc,docx,pdf,jpg,jpeg,png',
            'remarks'=>["required"],
        ];
    }

    public function messages(): array
    {
        return[
            'proposal_code.required'=>'The proposal code field is required.',
            'contractor_code.required'=>'The contractor id field is required.',
            'tender_id.required'=>'The tender id field is required.',
            'project_description.required'=>'The project description field is required.',
            'beneficiary.required'=>'The beneficiary field is required.',
            'project_value.required'=>'The project value field is required.',
            'bond_value.required'=>'The bond value field is required.',
            'bond_start_date.required'=>'The bond start date field is required.',
            'bond_end_date.required'=>'The bond end date field is required.',
            'bond_period.required'=>'The bond period field is required.',
            'locations.*.state_id'=>'The state field is required.',
            'locations.*.location'=>'The location field is required.',
            'attachment'=>'The attachment field is required.',
            'remarks'=>'The remarks field is required.',
        ];
    }
}
