<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    MobileNo,
    PinCode,
    AlphabetsAndNumbersV3,
    PinCodeV2,
};
use App\Models\{
    Country,
};
use Illuminate\Support\Str;

class InsuranceCompaniesRequest extends FormRequest
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
        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];

        return [
            'company_name' => ["required", new AlphabetsV1],
            'email' => 'required',
            'phone_no' => ["required", new MobileNo],
            'address' => ["required", new AlphabetsAndNumbersV3],
            'city' => ["required", new AlphabetsV1],
            'post_code' => $pincodeValidation,
            'country_id' => 'required',
            'state_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [];
    }

    public function prepareForValidation(){
        $country_id = request()->country_id;
        if($country_id) {
            $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
        }
        $country_name = Str::lower($name);

        $this->merge([
            'country_name'=>$country_name,
        ]);
    }
}
