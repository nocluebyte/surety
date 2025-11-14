<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Agent;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Rules\{
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV3,
    PanNo,
};

class AgentRequest extends FormRequest
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
        $agent_id = $this->get('id');

        return [
            'first_name' => ["required", new AlphabetsV1],
            'middle_name' => ["nullable", new AlphabetsV1],
            'last_name' => ["required", new AlphabetsV1],
            'email' => "required|unique:users,email,{$user_id},id,deleted_at,NULL",
            'mobile' => ["required", "unique:users,mobile,{$user_id},id,deleted_at,NULL", new MobileNo],
            'address' => ["required", new AlphabetsAndNumbersV3],
            'city' => ["required", new AlphabetsV1],
            'country_id' => 'required',
            'state_id' => 'required',
            'pan_no' => ["required_if:country_name,india", "unique:agents,pan_no,{$agent_id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new PanNo, "nullable"],
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
            "pan_no.required_if" => "The Pan No. is required when selected country is India.",
            "pan_no.prohibited_unless" => "The pan no field is prohibited unless country name is India",
            "mobile.unique" => "The Phone No. has already been taken.",
        ];
    }
}
