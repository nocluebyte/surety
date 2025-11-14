<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{  
    AlphabetsAndNumbersV5,    
    Numbers,
    AlphabetsAndNumbersV2,  
    AlphabetsAndNumbersV3, 
    MultipleFile,
    AlphabetsAndNumbersV8,
    MobileNo,
    ValidateExtensions,
};
use App\Models\DMS;

class BondPoliciesChecklistRequest extends FormRequest
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
        $performance_bond_id = $this->get('id');
        $contractor_type = $this->get('contractor_type');

        return [
            "premium_amount" => ["required", new Numbers],
            "utr_neft_details" => ["required", new AlphabetsAndNumbersV2],            
            "date_of_receipt" => "required",
            "booking_office_detail" =>["required", new AlphabetsAndNumbersV3],   
            "executed_deed_indemnity" => "required",
            "deed_attach_document.*" => [
                "required_if:executed_deed_indemnity,Yes",
                "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "deed_remarks" => "required_if:executed_deed_indemnity,No",
            "executed_board_resolution" => "required",
            "board_attach_document.*" =>[
                "required_if:executed_board_resolution,Yes",
                "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "board_remarks" => "required_if:executed_board_resolution,No",
            "broker_mandate" => "required",
            "broker_attach_document.*" => [
                "required_if:broker_mandate,Broker",
                "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "agent_attach_document.*" => [
                "required_if:broker_mandate,Agent",
                "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],
            "collateral_available" => "required",
            "collateral_remarks" => "required_if:collateral_available,No",
            "fd_amount" => ["required_if:collateral_available,Yes", new Numbers, "nullable"],
            "fd_issuing_bank_name" => ["required_if:collateral_available,Yes", new AlphabetsAndNumbersV3, "nullable"],  
            "fd_issuing_branch_name" => ["required_if:collateral_available,Yes", new AlphabetsAndNumbersV3, "nullable"],  
            "fd_receipt_number" => ["required_if:collateral_available,Yes", new AlphabetsAndNumbersV3, "nullable"],  
            "bank_address" => ["required_if:collateral_available,Yes", new AlphabetsAndNumbersV3, "nullable"],  
            "collateral_attach_document.*" => [
                "required_if:id,NULL",
                "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
            ],

            "intermediary_detail_type" =>'nullable|in:Agent,Broker,Direct',
            "intermediary_detail_id" =>"nullable|required_unless:intermediary_detail_type,Direct",
             "intermediary_detail_code" => ['required_with:intermediary_detail_id','nullable',new AlphabetsAndNumbersV8],
            "intermediary_detail_name" => ['required_with:intermediary_detail_id','nullable',new AlphabetsAndNumbersV8],
            "intermediary_detail_email" => ['required_with:intermediary_detail_id','nullable','email'],
            "intermediary_detail_mobile" => ['nullable',new MobileNo],
            "intermediary_detail_address" => ['nullable',new AlphabetsAndNumbersV3],
        ];
    }

    public function dmsAttachment($dmsItem) {
        $isUploaded = DMS::where('attachment_type', $dmsItem)->where('is_amendment')->where('deleted_at', NULL)->pluck('attachment')->first();
        // dd($this->get('id'));
        return $isUploaded;
    }

    public function prepareForValidation()
    {
        $categoryOne = [
            'deed_attach_document',
            'board_attach_document',
        ];

        $radioOne = [
            'executed_deed_indemnity',
            'executed_board_resolution',
        ];

        foreach ($categoryOne as $item1) {
            $attachmentExists = $this->dmsAttachment($item1) == NULL;
            $radioResponse = request()->input($radioOne[array_search($item1, $categoryOne)]);

            if (!$attachmentExists && in_array($radioResponse, ['No', 'Yes'])) {
                $result1 = false;
            } elseif ($attachmentExists && $radioResponse == 'Yes') {
                $result1 = true;
            } else {
                $result1 = false;
            }
            $finalDocList[$item1 . '_uploaded'] = $result1;
        }
    }
}
