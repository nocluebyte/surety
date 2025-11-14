<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Rules\{
    AlphabetsV1,
    AlphabetsAndNumbersV3,
    MobileNo,
    Numbers,
    PanNo,
};

class UnderWriterRequest extends FormRequest
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
        $user_id = $this->get('user_id');
        $underwriter_id = $this->get('id');

        return [
            "company_name" => ["required", new AlphabetsV1],
            "first_name" => ["required", new AlphabetsV1],
            "middle_name" => ["nullable", new AlphabetsV1],
            "last_name" => ["required", new AlphabetsV1],
            "type" => "required",
            "email" => "required|unique:users,email,{$user_id},id,deleted_at,NULL",
            "mobile" => ["required", "unique:users,mobile,{$user_id},id,deleted_at,NULL", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "state_id" => "required",
            "country_id" => "required",
            "pan_no" => ["required_if:country_name,india", "unique:underwriters,pan_no,{$underwriter_id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new PanNo, "nullable"],
            "max_approved_limit" => ["required", new Numbers],
            "individual_cap" => ["required", new Numbers],
            "overall_cap" => ["required", "gt:individual_cap", new Numbers],
            "group_cap" => ["required", "gt:overall_cap", new Numbers],
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
            "overall_cap.gt" => "The Overall Cap must be greater than Individual Cap.",
            "group_cap.gt" => "The Group Cap must be greater than Overall Cap.",
            "pan_no.required_if" => "The Pan No. is required when selected country is India.",
            "pan_no.prohibited_unless" => "The pan no field is prohibited unless country name is India",
        ];
    }
}
