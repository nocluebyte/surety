<?php

namespace App\Http\Requests;

use App\Rules\{
    Numbers,
    Decimal,
    NegativeDecimal
};
use Illuminate\Foundation\Http\FormRequest;

class CasesActionPlanFinancialsRequest extends FormRequest
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
            'losses.sales.*'=>['nullable','numeric'],
            'losses.exp.*'=>['nullable','numeric'],
            'losses.ebidta.*'=>['nullable'],
            'losses.int.*'=>['nullable','numeric'],
            'losses.dep.*'=>['nullable','numeric'],
            'losses.net_other.*'=>['nullable','numeric'],
            'losses.pbt.*'=>['nullable'],
            'losses.tax.*'=>['nullable','numeric'],
            'losses.pat.*'=>['nullable'],


            'balancea.cash.*'=>['nullable', 'numeric'],
            'balancea.tdrs.*'=>['nullable', 'numeric'],
            'balancea.quick.*'=>['nullable', 'numeric'],
            'balancea.stock.*'=>['nullable', 'numeric'],
            'balancea.other_ca.*'=>['nullable', 'numeric'],
            'balancea.total_ca.*'=>['nullable', 'numeric'],
            'balancea.fixed_assets.*'=>['nullable', 'numeric'],
            'balancea.intangible.*'=>['nullable', 'numeric'],
            'balancea.other_fa.*'=>['nullable', 'numeric'],
            'balancea.total_fa.*'=>['nullable', 'numeric'],
            'balancea.total_bs_a.*'=>['nullable', 'numeric'],

            'balanceb.std.*'=>['nullable', 'numeric'],
            'balanceb.tr_crs.*'=>['nullable', 'numeric'],
            'balanceb.other_cl.*'=>['nullable', 'numeric'],
            'balanceb.total_cl.*'=>['nullable', 'numeric'],
            'balanceb.provision.*'=>['nullable', 'numeric'],
            'balanceb.long_term.*'=>['nullable', 'numeric'],
            'balanceb.total_ltd.*'=>['nullable', 'numeric'],
            'balanceb.equity.*'=>['nullable', 'numeric'],
            'balanceb.retained.*'=>['nullable', 'numeric'],
            'balanceb.net_worth.*'=>['nullable', 'numeric'],
            'balanceb.total_bs_b.*'=>['nullable', 'numeric'],


            'ratios.ebidta.*'=>['nullable'],
            'ratios.bt.*'=>['nullable'],
            'ratios.icr.*'=>['nullable'],
            'ratios.drs.*'=>['nullable'],
            'ratios.crs.*'=>['nullable'],
            'ratios.stock_turnover.*'=>['nullable'],
            'ratios.credity_cycle.*'=>['nullable'],
            'ratios.term_gearing.*'=>['nullable'],
            'ratios.total_gearing.*'=>['nullable'],
            'ratios.solvability.*'=>['nullable'],
            'ratios.c_ratio.*'=>['nullable'],
            'ratios.quick_ratio.*'=>['nullable'],
            'ratios.working_capital.*'=>['nullable'],

        ];
    }
}
