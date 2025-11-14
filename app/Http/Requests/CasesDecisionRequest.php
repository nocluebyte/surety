<?php

namespace App\Http\Requests;

use App\Models\CasesActionPlan;
use App\Models\CasesBondLimitStrategy;
use App\Models\CasesLimitStrategy;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Numbers;

class CasesDecisionRequest extends FormRequest
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
        $validation = [
            'underwriter_id'=>'required',
            'decision_status'=>'nullable|in:Approved,Rejected',
        ];

        if ($this->decision_status != 'Rejected') {
            $validation = array_merge($validation, [
                'bond_value'=>['required','lte:proposed_overall_cap','lte:bond_remaining_cap',new Numbers],
                'bond_valid_till'=>'after_or_equal:today',
                'cases_limit_strategy_valid_till'=>'after_or_equal:today',
                'total_bond_utilized_cap'=>'lte:proposed_overall_cap',
                'bond_utilized_cap_with_bond_value'=>'lte:bond_remaining_cap|lte:bond_proposed_cap'
            ]);
        }

        return $validation;
    }

    public function prepareForValidation(){
        $cases_limit_strategy =  CasesLimitStrategy::where('is_current',0)->firstWhere('cases_action_plan_id',$this->case_action_plan_id);
        $bond_limit_strategy =  CasesBondLimitStrategy::where('is_current',0)->firstWhere(['cases_action_plan_id'=>$this->case_action_plan_id,'bond_type_id'=>$this->bond_type_id]);
        $case_action_plan = CasesActionPlan::firstWhere('id',$this->case_action_plan_id);

        //other cap cases limit stregy ot bond limit stregy
        $proposed_overall_cap = $cases_limit_strategy->proposed_overall_cap ?? 0;
        $bond_remaining_cap = $bond_limit_strategy->bond_remaining_cap ?? 0;
        $bond_proposed_cap = $bond_limit_strategy->bond_proposed_cap ?? 0;
        $bond_utilized_cap =   $case_action_plan->utilizedCasesBondLimitStrategy($this->bond_type_id,'sum') ?? 0;
        //valid till
        $bond_valid_till = $bond_limit_strategy->bond_valid_till ?? '';
        $cases_limit_strategy_valid_till = $cases_limit_strategy->proposed_valid_till ?? '';

        //bondvalue check if reject then 0 else actual bond value
        $virtual_bond_value = $this->decision_status === 'Rejected' ? 0 : $this->bond_value;

          //virtual limit when case is ammend
        $is_case_amend = (bool)$this->is_case_amend;
        $previous_bond_value = $this->previous_bond_value;
      
        
        $total_bond_utilized_cap = $this->total_bond_utilized_cap + $virtual_bond_value;
        $virtual_total_bond_utilized_cap = ($is_case_amend && $virtual_bond_value - $previous_bond_value === 0) ? $total_bond_utilized_cap - $previous_bond_value  : $total_bond_utilized_cap - $previous_bond_value;

        $bond_utilized_cap_with_bond_value = $bond_utilized_cap + $virtual_bond_value;

        $virtual_bond_utilized_cap_with_bond_value = ($is_case_amend && $virtual_bond_value - $previous_bond_value === 0) ? $bond_utilized_cap_with_bond_value - $previous_bond_value  : $bond_utilized_cap_with_bond_value - $previous_bond_value;

        // $virtual_bond_remaining_cap = ($is_case_amend && $virtual_bond_value - $previous_bond_value === 0) ? $bond_remaining_cap + $previous_bond_value : $bond_remaining_cap + $previous_bond_value;

        $virtual_bond_remaining_cap = $virtual_bond_utilized_cap_with_bond_value;

        $this->merge([
            'proposed_overall_cap'=>$proposed_overall_cap,
            'bond_remaining_cap'=>$virtual_bond_remaining_cap,
            'bond_valid_till'=>$bond_valid_till,
            'cases_limit_strategy_valid_till'=>$cases_limit_strategy_valid_till,
            'bond_proposed_cap'=>$bond_proposed_cap,
            'total_bond_utilized_cap'=>$virtual_total_bond_utilized_cap,
            'bond_utilized_cap_with_bond_value'=>$virtual_bond_utilized_cap_with_bond_value,
            'bond_value'=>$this->bond_value,
            'virtual_bond_value'=>$virtual_bond_value
        ]);
    }

    public function messages():array{
        return [
            'bond_value.lte:proposed_overall_cap'=>'Bond value should not be greater than overall cap.',
            'bond_value.lte:bond_remaining_cap'=>'Bond value should not be greater than bond type wise remaining cap.',
            'bond_valid_till.after_or_equal'=>'Bond type wise overall cap validity expired.',
            'cases_limit_strategy_valid_till.after_or_equal'=>'Overall cap validity expired.',
            'underwriter_id.required'=>'Please assign underwriter to take any action',
            'total_bond_utilized_cap.lte'=>'Proposed overall cap should be greater than sum of total utilized amount and bond value.',
            'bond_utilized_cap_with_bond_value.lte'=>' Proposed bond type wise remaining cap should be greater than sum of bond type wise utilized cap and bond value.'
        ];
    }
}
