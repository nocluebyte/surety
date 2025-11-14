<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    PinCode,
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV3,
    MultipleFile,
    PinCodeV2,
    ValidateExtensions,
};
use App\Models\{
    Employee,
    Country,
};
use Illuminate\Support\Str;

class EmployeeRequest extends FormRequest
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
        $user_id = $this->get('user_id');

        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];

        return [
            "first_name" => ["required", new AlphabetsV1],
            "middle_name" => ["nullable", new AlphabetsV1],
            "last_name" => ["required", new AlphabetsV1],
            "email" => "required|unique:users,email,{$user_id},id,deleted_at,NULL",
            "mobile" => ["required", "unique:users,mobile,{$user_id},id,deleted_at,NULL", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "post_code" => $pincodeValidation,
            "country_id" => "required",
            "state_id" => "required",
            "designation_id" => "required",
            "photo.*" => [
                "required_if:id,NULL", "file",
                "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            "photo_count" => "lte:5",
        ];
    }

    public function prepareForValidation(){
        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['photo'])) {
            $newDoc = count($requestData['photo']);
        }

        $employee_document = Employee::find($this->get('id'));

        $preDoc = 0;
        if(isset($employee_document->dMS)) {
            $preDoc = $employee_document->dMS->countBy('attachment_type')->first();
        }

        $docCount = $newDoc + $preDoc;

        $country_id = request()->country_id;
        if($country_id) {
            $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
        }
        $country_name = Str::lower($name);

        $this->merge([
            'country_name'=>$country_name,
            'photo_count' => $docCount,
        ]);
    }

    public function messages(): array
    {
        return [
            "photo_count.lte" => "The number of files for Photo must not exceed (5)",
        ];
    }
}
