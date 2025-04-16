<?php

namespace App\Http\Requests;

use App\Traits\General;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateNotificationsGroupsRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        $email = $this->email;        
        // $rules['name'] = ['required','max:255', 'min:1', 'unique:notifications_groups,name'];
        $rules['name'] = [
            'required',
            'max:255',
            'min:1',
            Rule::unique('notifications_groups', 'name')->whereNull('deleted_at')
        ];
        // foreach ($email as $e) {            
        //     $status = $this->is_email($e);
        //     if($status) {
        //         $rules['email'] = ['email'];
        //     }
        // }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập đầy đủ thông tin',
            'name.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'name.max' => 'Thông tin phải có tối đa 255 ký tự',              
            'name.unique' => 'Thông tin đã tồn tại trên hệ thống',   

            'email.required' => 'Vui lòng nhập đầy đủ Email',
            // 'email.email'    => 'Email không đúng định dạng'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
