<?php

namespace App\Http\Requests;

use App\Models\Leads;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgotPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {       
        
        return [                        
            'email' => ['required','max:255', 'min:1', 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/',function ($attribute, $value, $fail) {                
                $leads = Leads::where('email', $value)->count();                
                if ($leads <= 0) {
                    $fail('Email không tồn tại trên hệ thống');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            'email.required'    => 'Vui lòng nhập đầy đủ thông tin',
            'email.min'         => 'Thông tin phải có ít nhất 1 ký tự',
            'email.max'         => 'Thông tin phải có tối đa 255 ký tự',              
            'email.unique'      => 'Thông tin đã tồn tại trên hệ thống',   
            'email.regex'       => 'Email không đúng định dạng',   
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
