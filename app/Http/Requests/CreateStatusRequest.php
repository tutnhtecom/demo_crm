<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'name' => ['required','max:255', 'min:1', 'unique:lst_status,name'],
            'code' => ['nullable','max:150', 'min:7'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập đầy đủ thông tin',
            'name.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'name.max' => 'Thông tin phải có tối đa 255 ký tự',              
            'name.unique' => 'Thông tin đã tồn tại trên hệ thống',   

            'code.min' => 'Mã màu phải có độ dài tối thiểu 1 ký tự',
            'code.max' => 'Mã màu phải có độ dài đa 150 ký tự',            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
