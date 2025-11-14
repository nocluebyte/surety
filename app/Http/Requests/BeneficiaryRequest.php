<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{Country, Beneficiary, Role};
use App\Rules\{
    GstNo,
    PinCode,
    AlphabetsAndNumbersV2,
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV3,
    PanNo,
    MultipleFile,
    AlphabetsAndNumbersV8,
    PinCodeV2,
    ValidateExtensions,
};
use Illuminate\Support\Str;
use DB;

class BeneficiaryRequest extends FormRequest
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
        $beneficiary_id = $this->get('id');

        $pincodeValidation = $this->country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];

        return [
            // "company_code" => ["required", "unique:beneficiaries,company_code,{$beneficiary_id},id,deleted_at,NULL", new AlphabetsAndNumbersV2],
            // "reference_code" => ["required", "unique:beneficiaries,reference_code,{$beneficiary_id},id,deleted_at,NULL", new AlphabetsAndNumbersV2],
            "registration_no" => ["required", new AlphabetsAndNumbersV2],
            "company_name" => ["required", new AlphabetsAndNumbersV8],
            "email" => "nullable|unique:users,email,{$user_id},id,deleted_at,NULL",
            // "mobile" => ["required", new MobileNo],
            "mobile" => ["nullable", new MobileNo],
            "address" => ["required", new AlphabetsAndNumbersV3],
            "city" => ["required", new AlphabetsV1],
            "state_id" => "required",
            "country_id" => "required",
            "pan_no" => ["required_if:country_name,india", "unique:beneficiaries,pan_no,{$beneficiary_id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new PanNo, "nullable"],
            "gst_no" => ["required_if:country_name,india", "unique:beneficiaries,gst_no,{$beneficiary_id},id,deleted_at,NULL", "prohibited_unless:country_name,india", new GstNo, "nullable"],
            "beneficiary_type" => "required",
            "establishment_type_id" => "required",
            "ministry_type_id" => "required_if:beneficiary_type,Government|prohibited_unless:beneficiary_type,Government",
            // "bond_wording" => ["required", new AlphabetsAndNumbersV3],
            "bond_wording" => ["nullable", new AlphabetsAndNumbersV3],
            // "bond_attachment" => ["required_if:id,NULL|file|mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg", new MultipleFile(52428800, 5)],
            "bond_attachment.*" => ['file', 'mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg', new MultipleFile(52428800, 5), 'nullable', new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg'])],

            "website" => "nullable|url",
            "tradeSector.*.trade_sector_id" => "required",
            "tradeSector.*.from" => "required|date|before_or_equal:today",
            "tradeSector.*.till" => "nullable|date|after_or_equal:tradeSector.*.from",
            "pincode" => $pincodeValidation,
            "bond_attachment_count" => "lte:5",
            "unique_mobile" => "boolean:false",
        ];
    }

    public function prepareForValidation(){

        $country_id = request()->country_id;
        if($country_id) {
            $name = Country::select('name')->where('id', $country_id)->pluck('name')->first();
        }
        $country_name = Str::lower($name);

        $requestData = request()->all();

        $newDoc = 0;
        if(isset($requestData['bond_attachment'])) {
            $newDoc = count($requestData['bond_attachment']);
        }

        $beneficiary_document = Beneficiary::find($this->get('id'));

        $preDoc = 0;
        if(isset($beneficiary_document->dMS)) {
            $preDoc = $beneficiary_document->dMS->countBy('attachment_type')->first();
        }
        $docCount = $newDoc + $preDoc;

        $id = request()->id;
        $roleId = Role::where('slug', 'beneficiary')->value('id');
        $value  = request()->mobile;
        $checkField = '';
        if($value != ''){
            $checkField = DB::table('users')
            ->where('mobile',$value)
            ->where('roles_id', $roleId)
            ->whereNull('deleted_at')
            ->when($id, function ($query) use ($id) {
                $query->where('id', '!=', $id);
            })
            ->exists();
        }
        $uniqueMobileNo = $checkField == true && $id == null ? "exists" : false;

        $this->merge([
            'country_name'=>$country_name,
            'bond_attachment_count' => $docCount,
            'unique_mobile' => $uniqueMobileNo,
        ]);
    }

    public function messages(): array
    {
        return [
            "tradeSector.*.trade_sector_id.required" => "The trade sector field is required.",
            "tradeSector.*.from.date" => "Invalid Date Format",
            "tradeSector.*.from.before_or_equal" => "The Trade Sector 'From Date' must be a date before or equal to Today's Date.",
            "tradeSector.*.till.date" => "Invalid Date Format",
            "tradeSector.*.till.after_or_equal" => "The Trade Sector 'Till Date' must be a date after or equal to 'From Date'.",
            "bond_attachment_count.lte" => "The number of files for Bond Attachment must not exceed (5)",
            "unique_mobile" => "The Phone No. has already been taken.",
        ];
    }
}
