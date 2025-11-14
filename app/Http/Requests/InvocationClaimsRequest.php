<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{  
    AlphabetsAndNumbersV5,    
    Numbers,
    AlphabetsAndNumbersV2,  
    AlphabetsAndNumbersV3, 
};


class InvocationClaimsRequest extends FormRequest
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
            'bond_detail' => 'required',
            "conditional" => ["required"],
            'bond_wording' => 'required',
            'invocation_notice_date' => 'required',
            'invocation_claim_date' => 'required',
            'claim_form' => 'required',
            'claim_form_attachment' => "required_if:claim_form,Yes",
            'invocation_notice' => 'required',
            'invocation_notice_attachment' => "required_if:invocation_notice,Yes",
            'contract_copy' => 'required',
            'contract_copy_attachment' => "required_if:contract_copy,Yes",
            'correspondence_details' => 'required',
            'correspondence_detail_attachment' => "required_if:correspondence_details,Yes",
            'arbitration' => 'required',
            'arbitration_attachment' => "required_if:arbitration,Yes",
            'dispute' => 'required',
            'dispute_attachment' => "required_if:dispute,Yes",
            'bank_name' => 'required',
            'account_number' => 'required',
            'bank_address' => 'required',            
            'account_type' => 'required',            
            'micr' => 'required',            
            'ifsc_code' => 'required',            
            'claimed_amount' => ['required',new Numbers],            
            'claimed_disallowed' =>  ['required',new Numbers],           
            'total_claim_approved' => 'required',            
            'remark' => 'required',            
            // 'approval_note_attachment' => 'required',            
            'status' => 'required',            
        ];
    }
}
