<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\Leads;
use App\Models\Students;
use App\Models\User;
use App\Traits\General;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        $rules = [];
        if(!isset($this->email)) {
            $rules['email'] = ["required"] ;
        } else {
            $str_email = $this->is_email($this->email);
            if($str_email) {
                $rules['email'] = ['required','regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/', function ($attribute, $value, $fail) {
                    if (strlen($value) > 255) {
                        $fail('Độ dài tối đa của Email phải nhỏ hơn 255 ký tự');
                    }
                    if (strlen($value) < 4) {
                        $fail('Độ dài tối thiểu của Email phải nhỏ hơn 1 ký tự');
                    }
                    $status = $this->check_email($this->email);
                    if($status == false) {
                        $fail('Tài khoản không tồn tại trên hệ thống');
                    }
                    $user = User::where('email', $value)->first();
                    if ($user) {
                        if ($user->status == 0) {
                            $fail('Tài khoản chưa được kích hoạt');
                        }
                    }
                }];
            } else {
                $rules['email'] = ['required','regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/', function ($attribute, $value, $fail) {
                    if (strlen($value) > 12) {
                        $fail('Độ dài tối đa của Số điện thoại phải nhỏ hơn 12 ký tự');
                    }
                    if (strlen($value) < 10) {
                        $fail('Độ dài tối thiểu của Số điện thoại phải lớn hơn 10 ký tự');
                    }
                    if($this->types){
                        switch ($this->types) {
                            case User::TYPE_LEADS:
                                if($this->types == User::TYPE_LEADS){
                                    $leads = Leads::where('phone', $value)->first();
                                    if(isset($leads->email)) {
                                        $status = $this->check_email($leads->email);
                                        if($status == false) {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                        }
                                    } else {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                    }
                                }
                                break;
                            case User::TYPE_STUDENTS:
                                if($this->types == User::TYPE_STUDENTS){
                                    $student = Students::where('phone', $value)->first();
                                    if(isset($student->email)) {
                                        $status = $this->check_email($student->email);
                                        if($status == false) {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                        }
                                    } else {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                    }
                                }
                                break;
                            case User::TYPE_EMPLOYEES:
                                if($this->types == User::TYPE_EMPLOYEES){
                                    $employees = Employees::where('phone', $value)->first();
                                    if(isset($employees->email)) {
                                        $status = $this->check_email($employees->email);
                                        if($status == false) {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                        }
                                    } else {
                                            $fail('Tài khoản không tồn tại trên hệ thống');
                                    }
                                }
                                break;
                        }
                    }

                }];
            }
        }
        $rules['password'] = ['required', 'min:8'];
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập tài khoản',
            'email.regex' => 'Thông tin tài khoản không đúng định dạng',

            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors  ]));
    }
}
