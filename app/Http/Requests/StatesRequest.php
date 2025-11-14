<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Country;
use App\Rules\{
    AlphabetsV1,
    Numbers,
};
use Illuminate\Support\Str;

class StatesRequest extends FormRequest
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
        $id = $this->get('id');
        return [
            'country_id' => 'required',
            'name' => ["required", "unique:states,name,{$id},id,deleted_at,NULL", new AlphabetsV1],
            'gst_code' => ["required_if:country_name,india", "prohibited_unless:country_name,india", "lte:999", new Numbers, "nullable"],
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'country_id.required' => trans("state.validation_country_required"),
            'state.required' => trans("state.validation_state_required"),
            'state.unique' => trans("state.validation_state_unique"),
            'gst_code.required' => trans("state.validation_gst_code_required"),
            'gst_code.numeric' => trans("state.validation_gst_code_number"),
            'gst_code.prohibited_unless' => 'The gst code field is prohibited unless country name is India',
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
}
