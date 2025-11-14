<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    AlphabetsAndNumbersV3,
    MultipleFile,
    ValidateExtensions,
};
use App\Models\AdverseInformation;

class AdverseInformationRequest extends FormRequest
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
        // dd($this->all());
        return [
            "contractor_id" => "required",
            "source_of_adverse_information" => ["required", new AlphabetsAndNumbersV3],
            "adverse_information" => "required",
            "adverse_information_attachment.*" => ["required_if:id,NULL", "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", new MultipleFile(52428800, 5), new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls'])],
            "source_date" => "required",
            "adverse_information_attachment_count" => "lte:5",
        ];
    }

    public function prepareForValidation()
    {
        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['adverse_information_attachment'])) {
            $newDoc = count($requestData['adverse_information_attachment']);
        }

        $adverse_information = AdverseInformation::find($this->get('id'));

        $preDoc = 0;
        if(isset($adverse_information->dMS)) {
            $preDoc = $adverse_information->dMS->countBy('attachment_type')->first();
        }

        $docCount = $newDoc + $preDoc;
        $this->merge([
            'adverse_information_attachment_count' => $docCount,
        ]);
    }

    public function messages()
    {
        return [
            "adverse_information_attachment_count.lte" => "The number of files for Adverse Information Attachment must not exceed (5)",
        ];
    }
}
