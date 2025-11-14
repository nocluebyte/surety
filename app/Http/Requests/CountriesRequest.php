<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    Numbers,
};

class CountriesRequest extends FormRequest
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
            'name' => ["required", "unique:countries,name,{$id},id,deleted_at,NULL", new AlphabetsV1],
            "phone_code" => ["required", "lte:999", new Numbers],
            "code" => ["required", "lte:999", new Numbers],
            "mid_level" => "required",
            // 'short_name' => "required",
            // 'symbol' => "required",
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [];
    }
}
