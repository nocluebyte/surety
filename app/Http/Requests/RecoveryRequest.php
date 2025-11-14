<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Numbers,
    Remarks
};
use App\Models\InvocationNotification;

class RecoveryRequest extends FormRequest
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
            'total_approved_bond_value'=>['required',new Numbers],
            'claimed_amount'=>['required',new Numbers],
            'disallowed_amount'=>['required',new Numbers],
            'invocation_remark'=>['required',new Remarks],
            'remark'=>['required',new Remarks],
            'recovery_date'=>'required|date|before_or_equal:today',
            'recovery_amount'=>['required','lte:total_outstanding_amount',new Remarks],
        ];
    }

    public function prepareForValidation(){
        $invocationNotification = InvocationNotification::firstWhere('id',$this->invocation_notification_id);

        $total_outstanding_amount = $invocationNotification->total_outstanding_amount ?? 0;

        $this->merge([
            'total_outstanding_amount'=>$total_outstanding_amount
        ]);
    }

    public function messages():array{
        return [
            'recovery_amount.lte'=>'recovery amount must be less then or equal to outstanding amount.',
            'recovery_date.before_or_equal'=>'recovery date must be less then or equal to today.'
        ];
    }
}
