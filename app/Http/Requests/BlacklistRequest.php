<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Blacklist;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};
use Illuminate\Validation\Rules\File;

class BlacklistRequest extends FormRequest
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
            "contractor_id" => "required_if:id,NULL",
            "reason" => "required",
            "blacklist_attachment.*" => ["required_if:id,NULL", "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", new MultipleFile(52428800, 5), new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls'])],
            "source" => "required",
            "blacklist_date" => "required",
            "blacklist_attachment_count" => "lte:5",
        ];
    }

    public function prepareForValidation()
    {
        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['blacklist_attachment'])) {
            $newDoc = count($requestData['blacklist_attachment']);
        }

        $adverse_information = Blacklist::find($this->get('id'));

        $preDoc = 0;
        if(isset($adverse_information->dMS)) {
            $preDoc = $adverse_information->dMS->countBy('attachment_type')->first();
        }

        $docCount = $newDoc + $preDoc;
        $this->merge([
            'blacklist_attachment_count' => $docCount,
        ]);
    }

    public function messages()
    {
        return [
            "blacklist_attachment_count.lte" => "The number of files for Blacklist Attachment must not exceed (5)",
        ];
    }
}
