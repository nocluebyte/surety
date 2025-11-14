<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\LetterOfAward;
use App\Rules\{
    AlphabetsAndNumbersV3,
    MultipleFile,
    ValidateExtensions,
};
use Illuminate\Support\Str;
use DB;

class LetterOfAwardRequest extends FormRequest
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
        return [
            "contractor_id" => "required",
            "beneficiary_id" => "required",
            "project_details_id" => "required",
            "tender_id" => "required",
            "ref_no_loa" => ["required", new AlphabetsAndNumbersV3],
            "loa_attachment.*" => [
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            "loa_attachment_count" => "lte:5",
        ];
    }

    public function prepareForValidation(){
        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['loa_attachment'])) {
            $newDoc = count($requestData['loa_attachment']);
        }

        $loa_document = LetterOfAward::find($this->get('id'));

        $preDoc = 0;
        if(isset($loa_document->dMS)) {
            $preDoc = $loa_document->dMS->countBy('attachment_type')->first();
        }
        $docCount = $newDoc + $preDoc;

        $this->merge([
            'loa_attachment_count' => $docCount,
        ]);
    }
}
