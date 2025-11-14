<?php

namespace App\Http\Requests;

use App\Rules\Remarks;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    GstNo,
    PinCode,
    AlphabetsV1,
    AlphabetsAndNumbersV2,
    MobileNo,
    PanNo,
    AlphabetsAndNumbersV3,
    Numbers,
    AlphabetsV3,
    AlphabetsAndNumbersV4,
    PinCodeV2,
};
use App\Models\Country;
use Illuminate\Support\Str;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
        // dd(request()->all());
        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];
        if ($this->get('group') == "company") {
            $validation = [
                'project_title' => ["required", new AlphabetsV1],
                'company_name' => ["required", new AlphabetsV1],
                'tag_line' => ["nullable", new AlphabetsV1],
                'copyright_name'=>['required', new Remarks],
                'company_address' => ["required", new AlphabetsAndNumbersV3],

                'gst_no' => ["required_if:country_name,india", "prohibited_unless:country_name,india", new GstNo, "nullable"],

                'pan_no' => ["required_if:country_name,india", "prohibited_unless:country_name,india", new PanNo, "nullable"],

                'mobile' => ["required", new MobileNo],

                'country_id' => 'required',

                'state_id' => 'required',

                'iec_no' => ["nullable", new AlphabetsAndNumbersV2],

                'msme_no' => ["nullable", new AlphabetsAndNumbersV2],

                'city' => ["required", new AlphabetsV1],

                'pincode' => $pincodeValidation,

                'logo' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',

                'favicon' => 'nullable|file|mimes:png,jpg,jpeg|max:2048',

                'cin_no' => ["required", new AlphabetsAndNumbersV2],
            ];
        } elseif ($this->get('group') == "session") {
            $validation = [
                'session_expire_time' => ["required", new Numbers, "lte:999", "gte:0"],
                'token_expire_time' => ["required", new Numbers, "lte:30", "gte:0"],
                'proposal_auto_save_duration' => ["required", new Numbers, "lte:60", "gte:2"],
            ];
        } elseif ($this->get('group') == "bond_start_period") {
            $validation = [
                'bond_start_period' => ["required", new Numbers, "lte:999", "gte:0"],
                'initial_fd_validity' => ["required", new Numbers, "gt:0", "lte:365"],
                'extension_period' => ["required", new Numbers, "gt:0", "lte:999"],
                'expiring_bond' => ["required", new Numbers, "gt:0", "lte:180"],
            ];
        } else if ($this->get('group') == "print") {
            $validation = [
                'print_logo' => "required_if:id,NULL|file|mimes:png,jpg,jpeg|max:20480",
                'print_company_address_title' => ["required", new AlphabetsV3],
                'print_company_address' => ["required", new AlphabetsAndNumbersV4],
                'print_email_id' => "required|email",
                'print_title' => ["required", new AlphabetsV3],
                'print_disclosure' => ["required"],

                'prints.*.print_title' => ["required", new AlphabetsAndNumbersV2],
                'prints.*.print_description' => "required",
            ];
        }
        else {
            $validation = [];
        }

        return $validation;
    }

    public function prepareForValidation(){

        if($this->get('group') == "company") {
            $country_id = request()->country_id;
            if($country_id) {
                $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
            }
            $country_name = Str::lower($name);
            $this->merge([
                'country_name'=>$country_name
            ]);
        }
    }

    public function messages(): array
    {
        return [
            "gst_no.required_if" => "The GST No. is required when selected country is India.",
            "gst_no.prohibited_unless" => "The GST No. field is prohibited unless country name is India",
            "pan_no.required_if" => "The Pan No. is required when selected country is India.",
            "pan_no.prohibited_unless" => "The pan no field is prohibited unless country name is India",
            "oo_cbo_bo_kbo.unique" => "OO/CBO/BO/KBO No. has already been taken.",
            "micr.unique" => "MICR No. has already been taken.",
            "prints.*.print_title" => "Print Title must only contain letters, numbers, hyphens, slashes, and spaces.",
            "prints.*.print_description" => "Print Description is required",
            "expiring_bond.gt" => "You are not allow to add days less then 1.",
            "expiring_bond.lte" => "You are not allow to add days more then 180.",
        ];
    }
}
