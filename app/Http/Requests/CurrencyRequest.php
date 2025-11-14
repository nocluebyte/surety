<?php

namespace App\Http\Requests;
use App\Rules\AlphabetsV4;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        return [
            'country_id' => "required|",
            'short_name' => "required|unique:currencys,short_name," . request()->id . ",id,deleted_at,NULL",
            'symbol' => ["required", new AlphabetsV4],
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
