<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsAndNumbersV3,
    AlphabetsV1,
    GstNo,
    Numbers,
    AlphabetsAndNumbersV1,
    AlphabetsAndNumbersV6,
    AlphabetsV5,
    AlphabetsAndNumbersV2,
};
use App\Models\Country;
use Illuminate\Support\Str;

class IssuingOfficeBranchRequest extends FormRequest
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
        $id = $this->get('id');
        return [
            "branch_name" => ["required", new AlphabetsAndNumbersV3],
            "branch_code" => ["required", "unique:issuing_office_branches,branch_code,{$id},id,deleted_at,NULL", new AlphabetsAndNumbersV2],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "country_id" => "required",
            "state_id" => "required",
            "city" => ["required", new AlphabetsV1],
            // "cin_no" => ["required", new AlphabetsAndNumbersV3],
            "gst_no" => ["required_if:country_name,india", "unique:issuing_office_branches,gst_no,{$id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new GstNo, "nullable"],
            // "sac_code" => ["required", new Numbers],
            "oo_cbo_bo_kbo" => ["required", "unique:issuing_office_branches,oo_cbo_bo_kbo,{$id},id,deleted_at,NULL", new Numbers],
            "bank" => ["required", new AlphabetsAndNumbersV3],
            "bank_branch" => ["required", new AlphabetsAndNumbersV3],
            "account_no" => ["required", new AlphabetsAndNumbersV6],
            "ifsc" => ["required", new AlphabetsAndNumbersV1],
            "micr" => ["required", "unique:issuing_office_branches,micr,{$id},id,deleted_at,NULL", new Numbers],
            "mode" => ["required"],
        ];
    }

    public function prepareForValidation(){

        $country_id = request()->country_id;
        if($country_id) {
            $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
        }
        $country_name = Str::lower($name);
        $this->merge([
            'country_name'=>$country_name
        ]);
    }

    public function messages(): array
    {
        return [
            "gst_no.required_if" => "The GST No. is required when selected country is India.",
            "gst_no.prohibited_unless" => "The GST No. field is prohibited unless country name is India",
            "oo_cbo_bo_kbo.unique" => "OO/CBO/BO/KBO No. has already been taken.",
            "micr.unique" => "MICR No. has already been taken.",
            "branch_code.unique" => "Branch Code has already been taken.",
        ];
    }
}
