<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\{
    MultipleFile,
    ValidateExtensions,
};

class DmsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->get('id', false);
        return [
            'dmsamend_id'=>'required_if:type,NULL',
            'document_type_id'=>'required_if:type,NULL',
            'file_source_id'=>'required_if:type,NULL',
            'final_submission'=>'required_if:type,NULL',
            'attachment.*'=>[
                "required_if:id,NULL",
                "file", "mimes:pdf,xlsx,xls,doc,docx,png,jpg,jpeg",
                new MultipleFile(52428800, 5),
                new ValidateExtensions(['pdf', 'xlsx', 'xls', 'doc', 'docx', 'png', 'jpg', 'jpeg']),
            ],
            'file_name'=>($id > 0) ? 'required' : '',
        ];
    }

    public function messages()
    {
        $id = $this->get('id', false);
        $messages = [
            'dmsamend_id.required'=>'The contractor field is required.',
            'document_type_id.required'=>'The document type field is required.',
            'file_source_id.required'=>'The file source field is required.',
            'final_submission.required'=>'The is final submission field is required.',
            // 'attachment.required'=>($id > 0) ? '' :'The is attachment field is required.',
            // 'file_name.required'=>($id > 0) ? 'The is file name field is required.' :''
        ];
        if($id <= 0){
            $messages['attachment.required']='The is attachment field is required.';
        }
        if($id > 0){
            $messages['file_name.required']='The is file name field is required.';
        }
        return $messages;
    }
}
