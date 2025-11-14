<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Rules\{
    AlphabetsAndNumbersV1,
};

class TenureRequest extends FormRequest
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
        $id = $this->id;
        return [
            'name' => [
                'required',
                'unique:tenures,name,' . request()->route('tenure') . ',id,name,deleted_at',
                new AlphabetsAndNumbersV1,
            ]
        ];
    }
}
