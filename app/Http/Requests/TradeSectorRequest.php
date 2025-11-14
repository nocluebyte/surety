<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\AlphabetsV1;

class TradeSectorRequest extends FormRequest
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
            'name' => ["required", "unique:trade_sectors,name,{$id},id,deleted_at,NULL", new AlphabetsV1],
            'mid_level' => 'required',
        ];
    }

    public function message(): array
    {
        return [];
    }
}
