<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsV1,
    AlphabetsAndNumbersV3,
};

class ReasonRequest extends FormRequest
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
        $id = $this->get('id');
        return [
            "reason" => ["required", "unique:reasons,reason,{$id},id,deleted_at,NULL", new AlphabetsV1],
            "description" => ["required", new AlphabetsAndNumbersV3],
        ];
    }
}
