<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Numbers,
    Remarks
};

class InvocationNotificationPayoutRequest extends FormRequest
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
            'invocation_amount'=>['required',new Numbers],
            'claimed_amount'=>['required','lte:invocation_amount',new Numbers],
            'disallowed_amount'=>['required','lte:invocation_amount',new Numbers],
            'total_approved_bond_value'=>['required','lte:invocation_amount',new Numbers],
            'payout_remark'=>['required',new Remarks]
        ];
    }
}
