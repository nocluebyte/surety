<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\{
    AlphabetsV1,
    MobileNo,
    AlphabetsAndNumbersV8,
};

class UserRequest extends FormRequest
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
        $id  = $this->get('id');
        $role_id  = $this->get('roles_id');

        $role = Role::where('id', $role_id)->select(['slug'])->first();
        if(in_array($role->slug,['beneficiary','contractor'])){
			$last_name = ['nullable', new AlphabetsV1];
            $first_name = ['required', new AlphabetsAndNumbersV8];
        }else{
			$last_name = ['required', new AlphabetsV1];
            $first_name = ['required', new AlphabetsV1];
        }
        if(in_array($role->slug,['beneficiary'])){
			$mobile_no = ['nullable', new MobileNo];
        }else{
			$mobile_no = ['required', new MobileNo];
        }
        
        $validation =  [
            // 'emp_type' => 'required',
			'first_name' => $first_name,
            'middle_name' => ["nullable", new AlphabetsV1],
			'last_name' => $last_name,
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            // 'location_id' => 'required',
			'mobile' => $mobile_no,
			// 'roles_id' => 'required',
			//'process' => 'required',            

        ];

        if(!$id){
            $validation['password'] = 'required|confirmed|min:8|regex:/^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*[$!@#$%^_&*!?)(,]{1,}).{6,}$/';
            $validation['password_confirmation'] = 'required|min:8';
        }
        if($this->has('is_ip_base')){
            $valid=true;
            foreach($this->get('loginips') as $value){
                if($value['login_ip'] != '' || $value['login_ip'] != null){
                    $valid = false;
                }
            }
            if($valid){
                $validation['loginips.0.login_ip'] = 'required';
            }
        }
        //dd($validation);
        return $validation;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'emp_type.required' => 'The '.trans("users.form.user_type").' field is required.',
            // 'location_id.required' => 'The '.trans("users.form.location").' field is required.',
            // 'roles_id.required' => 'The '.trans("users.form.roles").' field is required.',            
            'loginips.0.login_ip.required' => 'Please add at least one ip address.',            
        ];
    }
}
