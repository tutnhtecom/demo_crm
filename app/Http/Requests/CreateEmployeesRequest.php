<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\User;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateEmployeesRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {   
        return [
            'name'          => ['required', 'max:255', 'min:1'],    
            'email'         => ['required', 'max:255', 'min:1', function ($attribute, $value, $fail) {
                $eEmployeesUnique = Employees::where('email', $value)->count();
                $eUserUnique = User::where('email', $value)                            
                             ->count();                
                if ($eEmployeesUnique > 0 || $eUserUnique > 0 || $this->email == $this->get_email_admin()) {
                    $fail('Email đã được đăng ký trên hệ thống');
                }
            }],    
            'phone'         => ['required', 'numeric' , function ($attribute, $value, $fail) {
                $dem = Employees::where('phone', $value)->count();
                if($dem > 0) {
                    $fail('Số điện thoại đã tồn tại');
                }
                if(strlen($value) > 13){
                    $fail('Độ dài tối đa 13 kí tự');
                }
            }],
            'date_of_birth' => ['required', 'date_format:d/m/Y', 'before:'. Carbon::now()->format('d/m/Y')],
            'roles_id'      => ['required', function ($attribute, $value, $fail) {                                
                $dem = Roles::where('id', $value)->count();
                if ($dem <= 0) {
                    $fail('Vai trò không tồn tại trên hệ thống');
                }                
                $permissions = RolePermissions::where('roles_id', (int)$value)->get()->pluck('permissions_id')->toArray(); 
                if(count($permissions) <= 0) {
                    $fail('Vai trò chưa được gán quyền');
                }
            }],
            'password'      => ['nullable', 'min:8']
        ];
    }
    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập Họ và tên',
            'name.min'                  => 'Họ và tên phải có ít nhất 1 ký tự',
            'name.max'                  => 'Họ và tên phải có tối đa 255 ký tự',  
            
            'phone.required'            => 'Vui lòng nhập Số điện thoại',                        
            'phone.numeric'             => 'Số điện thoại không đúng định dạng',                                  

            'email.required'            => 'Vui lòng nhập Email ',            
            'email.unique'              => 'Email này đã tồn tại', 
            'email.max'                 => 'Độ dài email tối đa 255 ký tự',  
            'email.email'               => 'Email không đúng định dạng',  
              
            'date_of_birth.required'    => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date_format' => 'Ngày sinh không đúng định dạng d/m/Y',           
            'date_of_birth.before'      => 'Ngày sinh phải nhỏ hơn ngày hiện tại',           

            'roles_id.required'         => 'Vui lòng chọn vai trò',
            'password.min'              => 'Độ dài của mật khẩu phải tối thiểu 8 ký tự'
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }   
}
