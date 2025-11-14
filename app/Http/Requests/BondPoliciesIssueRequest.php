<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV3,
    AlphabetsAndNumbersV5,
    Numbers,
    Remarks,
    PercentageV1,
    AlphabetsAndNumbersV8,
};

class BondPoliciesIssueRequest extends FormRequest
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
            'insured_name' => ['required', new AlphabetsAndNumbersV8],
            'insured_address' => ['required', new AlphabetsAndNumbersV3],
            // 'bond_number' => ['nullable', new Remarks],
            'project_details' => ['required'],
            'beneficiary_id' => 'required',
            'beneficiary_address' => ['required', new AlphabetsAndNumbersV3],
            'beneficiary_phone_no' => ['required', new MobileNo],
            'bond_conditionality' => 'required',
            'contract_value' => ['required', new Numbers, 'gt:0'],
            'contract_currency' => 'required',
            'bond_value' => ['required', new Numbers, 'gte:0'],
            'cash_margin' => ['required', new PercentageV1, 'gte:0'],
            // 'tender_id' => ['required', new ],
            'bond_period_start_date' => 'required',
            'bond_period_end_date' => 'required|date|after_or_equal:bond_period_start_date',
            'bond_period' => ['required', new Numbers],
            'rate' => ['required', new PercentageV1, 'gte:0'],
            'net_premium' => ['required', new Numbers, 'gte:0'],
            'gst' => ['required', new Numbers, 'gte:0', 'lte:100'],
            'gst_amount' => ['required', new Numbers, 'gte:0'],
            'gross_premium' => ['required', new Numbers, 'gte:0'],
            'stamp_duty_charges' => ['required', new Numbers, 'gte:0'],
            'total_premium' => ['required', new Numbers, 'gte:0'],
            'intermediary_name' => ['nullable'],
            'intermediary_code' => 'nullable',
            //'phone_no' => ['required', new MobileNo],
            'special_condition' => ['required', new Remarks],
            'premium_date' => 'nullable|date',
        ];
    }
}
