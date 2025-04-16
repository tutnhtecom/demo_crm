<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'max:100', 'min:2',],
            'phone' => ['required', 'max:15', 'min:5', 'unique:employees,phone'],
            // 'email' => ['required', 'max:255', 'min:8', 'email', 'unique:users,email'],
            'email' => ['required', 'max:255', 'min:8', 'email', Rule::unique('users', 'email')->whereNull('deleted_at')],
            'password' => ['required', 'min:8', 'regex:/(?=^.{8,16}$)((?=.*\d)(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập Họ và tên',
            'name.min'      => 'Họ và tên phải có ít nhất 2 ký tự',
            'name.max'      => 'Họ và tên phải có tối đa 255 ký tự',

            'phone.required' => 'Vui lòng nhập Số điện thoại',
            'phone.min'      => 'Số điện thoại phải có ít nhất 5 ký tự',
            'phone.max'      => 'Số điện thoại phải có tối đa 15 ký tự',
            'phone.unique'   => 'Số điện thoại đã tồn tại',

            'email.required' => 'Vui lòng nhập Email',
            'email.min'      => 'Email phải có ít nhất 8 ký tự',
            'email.max'      => 'Email phải có tối đa 255 ký tự',
            'email.email'    => 'Email không đúng định dạng',
            'email.unique'   => 'Email đã tồn tại',

            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min'      => 'Mật khẩu phải có ít nhất 8 ký tự',            
            'password.regex'    => 'Vui lòng nhập mật khẩu mạnh',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json(['code' => '422', 'data' => $errors]));
    }
}
