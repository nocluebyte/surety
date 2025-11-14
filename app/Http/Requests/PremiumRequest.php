<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Numbers,
    Remarks,
};

class PremiumRequest extends FormRequest
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
        return [
            "bond_type" => "required",
            "proposal_id" => "required",
            "tender_id" => "required",
            "beneficiary_id" => "required",
            "bond_value" => ["required", new Numbers],
            "payment_received" => ["required", new Numbers],
            "payment_received_date" => "required",
            "remarks" => ["required", new Remarks],
        ];
    }
}
