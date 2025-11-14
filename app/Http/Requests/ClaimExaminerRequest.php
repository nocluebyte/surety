<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    AlphabetsAndNumbersV3,
    MobileNo,
    Numbers,
    PinCode,
    PinCodeV2,
};
use Illuminate\Support\Str;
use App\Models\{
    Country,
};

class ClaimExaminerRequest extends FormRequest
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
        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];

        return [
            "first_name" => ["required", new AlphabetsV1],
            "middle_name" => ["nullable", new AlphabetsV1],
            "last_name" => ["required", new AlphabetsV1],
            "email" => "required|unique:users,email,{$user_id},id,deleted_at,NULL",
            "mobile" => ["required", "unique:users,mobile,{$user_id},id,deleted_at,NULL", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "state_id" => "required",
            "country_id" => "required",
            "max_approved_limit" => ["required", new Numbers],
            "post_code" => $pincodeValidation,
        ];
    }

    public function prepareForValidation()
    {
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
