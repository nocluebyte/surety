<?php

namespace App\Http\Requests;

use App\Rules\Remarks;
use Illuminate\Foundation\Http\FormRequest;

class InvocationReasonRequest extends FormRequest
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
            'reason'=>['required',"unique:invocation_reasons,reason,{$id},id,deleted_at,NULL",new Remarks],
            'description'=>['required',new Remarks]
        ];
    }
}
