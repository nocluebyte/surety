<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Numbers,
    AlphabetsAndNumbersV3,
    PinCode,
};

class HsnCodeRequest extends FormRequest
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
            "hsn_code" => ["required", new PinCode],
            "gst" => "required",
            "is_service" => "required",
            "cgst" => "required",
            "sgst" => "required",
            "igst" => "required",
            "description" => ["nullable", new AlphabetsAndNumbersV3],
        ];
    }
}
