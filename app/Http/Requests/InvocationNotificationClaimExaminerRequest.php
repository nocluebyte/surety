<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{
    User,
    ClaimExaminer,
    InvocationNotification,
};

class InvocationNotificationClaimExaminerRequest extends FormRequest
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
            'claim_examiner_id'=>'required',
            'is_valid_claim_examiner' => 'accepted:true',
            'is_claim_examiner_already_assigned' => 'accepted:true',
        ];
    }

    public function prepareForValidation(){
        list($claim_examiner_type, $claim_examiner_id) = parseGroupedOptionValue(request()->claim_examiner_id);

        $userMaxApprovedLimit = '';
        if($claim_examiner_type == 'User'){
            $userMaxApprovedLimit = User::where('id', $claim_examiner_id)->pluck('claim_examiner_max_approved_limit')->first();
        } else {
            $userMaxApprovedLimit = ClaimExaminer::where('id', $claim_examiner_id)->pluck('max_approved_limit')->first();
        }
        $checkMaxLimit = $userMaxApprovedLimit >= request()->invocation_amount ? true : false;

        $invocation_notification = InvocationNotification::where('id', request()->invocation_notification_id)->first();
        $checkAlreadyAssigned = isset($invocation_notification->claim_examiner_id) && $claim_examiner_id == $invocation_notification->claim_examiner_id ? false : true;

        $this->merge([
            'is_valid_claim_examiner' => $checkMaxLimit, 
            'is_claim_examiner_already_assigned' => $checkAlreadyAssigned,
        ]);
    }

    public function messages(): array
    {
        return [
            'is_valid_claim_examiner' => 'The Maximun Approved Limit of Claim Examiner should be greater than or equal to Invocation Amount.',
            'is_claim_examiner_already_assigned' => 'This Claim Examiner is already assigned to this Invocation Notification.',
        ];
    }
}
