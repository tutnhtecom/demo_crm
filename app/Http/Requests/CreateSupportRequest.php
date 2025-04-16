<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\Leads;
use App\Models\Students;
use App\Models\Tags;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSupportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'email' => ['required','email' ],             
            'tags_id' => ['nullable', 
            function ($attribute, $value, $fail) {     
                $model = Tags::where('id', $value)->first();
                if (!isset($model->id)) {
                    $fail('Thẻ này này không tồn tại trên hệ thống');
                }
            }],  
            'employees_id' => ['nullable', 
            function ($attribute, $value, $fail) {                      
                $dem = Employees::where('id', $value)->count();
                
                if ($dem <= 0) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],  
            "subject"=> ['required', "max:255", 'min:1'],
            "descriptions"  => ['required'],   
            "send_to"       => ['nullable', 'email'],
            "send_cc"       => ['nullable', 'email', function ($attribute, $value, $fail) {     
                $count = Employees::where('email', $value)->count();
                if ($count <= 0) {
                    $fail('Tư vấn viên không tồn tại trên hệ thống');
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng chọn email nhận yêu cầu hỗ trợ',
            'email.email' => 'Email không đúng định dạng',
            'subject.required' => 'Vui lòng nhập đầy đủ thông tin',
            'subject.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'subject.max' => 'Thông tin phải có tối đa 255 ký tự',              
            'descriptions.required' => 'Vui lòng nhập mô tả',  
            'send_to.email' => 'mail đến chưa đúng định dạng',  
            'send_cc.email' => 'mail này chưa đúng định dạng'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
