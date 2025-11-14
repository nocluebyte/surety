<?php

namespace App\Http\Requests;

use App\Models\Cases;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Remarks,
    Numbers
};
use App\Models\UnderWriter;

class CasesActionPlanRequest extends FormRequest
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
            'cases_action_reason_for_submission'=>'required',
            'cases_action_amendment_type'=>'required_if:cases_action_reason_for_submission,Amendment|in:TermSheet,Bond|nullable',
            'cases_action_adverse_notification'=>'required|in:Yes,No',
            'cases_action_adverse_notification_remark'=>['required_if:cases_action_adverse_notification,Yes',new Remarks,'nullable'],
            'cases_action_beneficiary_acceptable'=>'required|in:,Yes,No',
            'cases_action_beneficiary_acceptable_remark'=>['required_if:cases_action_beneficiary_acceptable,No',new Remarks,'nullable'],
            'cases_action_bond_invocation'=>'required|in:Yes,No',
            'cases_action_bond_invocation_remark'=>['required_if:cases_action_bond_invocation,Yes',new Remarks,'nullable'],
            'cases_action_blacklisted_contractor'=>'required|in:Yes,No',
            'cases_action_blacklisted_contractor_remark'=>['required_if:cases_action_blacklisted_contractor,Yes',new Remarks,'nullable'],
            'cases_action_audited'=>'nullable',
            'cases_action_consolidated'=>'nullable',
            'cases_action_currency_id'=>'nullable',
            'proposed.proposed_individual_cap'=>['required','lte:underwriter_individual_cap',new Numbers],
            'proposed.proposed_overall_cap'=>['required','lte:underwriter_overall_cap','gte:proposed.proposed_individual_cap',new Numbers],
            'proposed.proposed_group_cap'=>['required','lte:underwriter_group_cap',new Numbers],
            'proposed_valid_till'=>'date',
        ];
    }

    public function messages(): array{
        return [
            'underwriter_id.required'=>' Please assign underwriter to take any action.',
            'cases_action_reason_for_submission.required'=>'Reason for Submission Field is Required',

            'proposed.proposed_individual_cap.lte:underwriter_individual_cap'=>"Proposed individual cap should be less than underwriter's individual cap permission.",
            'proposed.proposed_overall_cap.lte:underwriter_overall_cap'=>"Proposed overall cap should be less than underwriter's overall cap permission.",
            'proposed.proposed_overall_cap.gte:proposed_individual_cap'=>'Proposed overall cap should be greater than individual cap.',
            'proposed.proposed_group_cap.lte:underwriter_group_cap'=>"Proposed group cap should be less than underwriter's group cap permission."

        ];
    }

    public function prepareForValidation() {
        $case = Cases::find($this->cases_id);
        
        $underwriter_individual_cap = $case->underwriter->individual_cap ?? 0;
        $underwriter_overall_cap = $case->underwriter->overall_cap ?? 0;
        $underwriter_group_cap = $case->underwriter->group_cap ?? 0;

        $this->merge([
            'underwriter_individual_cap'=>$underwriter_individual_cap,
            'underwriter_overall_cap'=>$underwriter_overall_cap,
            'underwriter_group_cap'=>$underwriter_group_cap
        ]);
    }
}
