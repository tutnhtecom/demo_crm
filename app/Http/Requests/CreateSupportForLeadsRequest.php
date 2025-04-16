<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\Leads;
use App\Models\Tags;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSupportForLeadsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'full_name' => ['required','max:255'],             
            'phone' => ['required','max:12', 'min:10', 'regex:/^\+?[0-9]+$/'],      
            'email' => ['required','email'],             
            'tags_id' => ['nullable', 
            function ($attribute, $value, $fail) {     
                $model = Tags::where('id', $value)->first();
                if (!isset($model->id)) {
                    $fail('Thẻ này này không tồn tại trên hệ thống');
                }
            }],  
            'employees_id' => ['nullable', 
            function ($attribute, $value, $fail) {                  
                $model = Employees::where('id', $value)->first();
                if (!isset($model->id)) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],  
            "subject"=> ['required', "max:255", 'min:1'],
            "descriptions"  => ['required'],   
            "send_to"       => ['nullable', 'email'],
            "send_cc"       => ['nullable', 'email']
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Vui lòng nhập Họ và tên',
            'full_name.max' => 'Độ dài Họ và tên cho phép tối đa 255 ký tự',
            'phone.required' => 'Vui lòng nhập Số điện thoại',
            'phone.min' => 'Độ dài Số điện thoại phải tối thiểu 10 ký tự',
            'phone.max' => 'Độ dài Số điện thoại cho phép tối đa 12 ký tự',   
            'phone.regex' => 'Số điện thoại không đúng định dạng',               
            'email.required' => 'Vui lòng chọn email gửi yêu cầu hỗ trợ',
            'email.email' => 'Email không đúng định dạng',
            'subject.required' => 'Vui lòng nhập đầy đủ thông tin',
            'subject.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'subject.max' => 'Thông tin phải có tối đa 255 ký tự',              
            'descriptions.required' => 'Vui lòng nhập Để lại câu hỏi',  
            'send_to.email' => 'Email đến chưa đúng định dạng',  
            'send_cc.email' => 'Email này chưa đúng định dạng'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
