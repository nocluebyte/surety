<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphabetsV1;

class ReInsuranceGroupingRequest extends FormRequest
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
        $id  = request()->id;
        return [
            'name' => ["required", "unique:re_insurance_groupings,name,{$id},id,deleted_at,NULL", new AlphabetsV1],
        ];
    }
}
