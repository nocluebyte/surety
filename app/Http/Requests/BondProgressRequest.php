<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    Numbers,
    Remarks,
    MultipleFile,
    ValidateExtensions,
};

class BondProgressRequest extends FormRequest
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
            "progress_date" => "required",
            "progress_remarks" => ["required", new Remarks],
            "physical_completion_remarks" => ["required", new Remarks],
            "dispute_initiated" => "required",
            "dispute_initiated_remarks" => ["required_if:dispute_initiated,Yes", new Remarks, "nullable"],
            "progress_attachment.*" => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            "physical_completion_attachment.*" => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
        ];
    }
}
