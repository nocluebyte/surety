<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsAndNumbersV1,
    AlphabetsV1,
    MobileNo,
    Numbers,
    Decimal,
    AlphabetsAndNumbersV4,
    AlphabetsAndNumbersV3,
    AlphabetsAndNumbersV5,
    PercentageV1,
};
class NbiRequest extends FormRequest
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
        // dd(request()->all());
        $pnbi_id = $this->get('id');
        $id = $this->get('id');
        return [
            "contractor_id" => "required",
            'insured_address' => ['required'],
            'project_details' => ['required'],
            "beneficiary_id" => "required",
            'beneficiary_address' => ['required',new AlphabetsAndNumbersV3],
            'beneficiary_contact_person_name' => ['required',new AlphabetsV1],
            'beneficiary_contact_person_phone_no' => ['required',new MobileNo],
            "bond_type" => "required",
            "bond_conditionality" => "required",
            'contract_value' => ['required',new Numbers],
            "contract_currency_id" => "required",
            'bond_value' => ['required',new Numbers],
            'cash_margin_if_applicable' => ['required',new PercentageV1],
            'cash_margin_amount' => ['required', new Numbers],
            'tender_id_loa_ref_no' => ['required'],
            'bond_period_start_date' => ['required'],
            'bond_period_end_date' => ['required'],
            'bond_period_days' => ['required', new Numbers],
            'initial_fd_validity' => 'required',
            'rate' => ['required', new PercentageV1],
            'net_premium' => ['required', new Numbers],
            'hsn_code_id' => ['required'],
            'gst_amount' => ['required', new Decimal],
            'gross_premium' => ['required', new Decimal],
            'stamp_duty_charges' => ['required', new Numbers],
            'total_premium_including_stamp_duty' => ['required', new Decimal],
            // 'intermediary_name' => ['required', new AlphabetsV1],
            // 'intermediary_code_and_contact_details' => ['required', new MobileNo],
            'bond_wording' => ['required'],
            //'bond_number' => ["required", "unique:nbis,bond_number,{$id},id,deleted_at,NULL", new AlphabetsAndNumbersV5],
        ];
    }

    public function messages(): array
    {
        return[
            "contractor_id.required" => "Insured name/ principal debtor required",
            "insured_address.required" => "Insured address required",
            "project_details.required" => "Project details required",
            "beneficiary_id.required" => "Beneficiary required",
            "beneficiary_address.required" => "Beneficiary address required",
            "beneficiary_contact_person_name.required" => "Beneficiary contact person name required",
            "beneficiary_contact_person_phone_no.required" => "Beneficiary contact person phone no required",
            "bond_type.required" => "Bond type required",
            "bond_conditionality.required" => "Bond conditionality required",
            "contract_value.required" => "Contract value required",
            "contract_currency_id.required" => "Contract currency required",
            "bond_value.required" => "Bond value required",
            "cash_margin_if_applicable.required" => "Cash margin if applicable required",
            "tender_id_loa_ref_no.required" => "Tender id loa ref no required",
            "bond_period_start_date.required" => "Bond period start date required",
            "bond_period_end_date.required" => "Bond period end date required",
            "bond_period_days.required" => "Bond period days required",
            "initial_fd_validity.required" => "Initial FD Validity required",
            "rate.required" => "Rate required",
            "net_premium.required" => "Net premium required",
            "hsn_code_id.required" => "GST required",
            "gst_amount.required" => "GST amount required",
            "gross_premium.required" => "GST premium required",
            "stamp_duty_charges.required" => "Stamp duty charges required",
            "total_premium_including_stamp_duty.required" => "Total premium including stamp duty required",
            "intermediary_name.required" => "Intermediary name required",
            "intermediary_code_and_contact_details.required" => "Intermediary code and contact details required",
            "bond_wording.required" => "Bond wording required",
            //"bond_number.required" => "Bond Number required",
        ];
    }
}
