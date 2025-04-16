<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name'          => ['required', 'max:255', 'min:4'],    
            'email'         => ['nullable', 'max:255', 'min:4', 'unique:employees,email,' . $this->id],    
            'phone'         => ['required', 'min:10', 'unique:employees,phone,' . $this->id],
            'date_of_birth' => ['required', 'date_format:d/m/Y', 'before:now']
        ];
    }
    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập Họ và tên',
            'name.min'                  => 'Họ và tên phải có ít nhất 1 ký tự',
            'name.max'                  => 'Họ và tên phải có tối đa 255 ký tự',  
            
            'phone.required'            => 'Vui lòng nhập Số điện thoại',            
            'phone.unique'              => 'Số điện thoại đã tồn tại', 
            'phone.regex'               => 'Số điện thoại không đúng định dạng', 
            'phone.unique'              => 'Số điện thoại đã tồn tại', 

            'email.required'            => 'Vui lòng nhập Email ',            
            'email.unique'              => 'Email này đã tồn tại', 
            'email.max'                 => 'Độ dài email tối đa 255 ký tự',  
            'email.email'               => 'Email không đúng định dạng',  
              
            'date_of_birth.required'    => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date_format' => 'Ngày sinh không đúng định dạng d/m/Y',           
            'date_of_birth.before'      => 'Ngày sinh phải nhỏ hơn ngày hiện tại',           
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }   
}
