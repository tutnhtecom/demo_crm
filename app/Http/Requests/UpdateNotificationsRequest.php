<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateNotificationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {          
        
        $rules = [
            'title'         => ['nullable','max:150', 'min:8'],
            'content'       => ['nullable', 'min:8'],
            'obj_types'     => ['nullable', 'in:0,1,2'],
            'status'        => ['nullable', 'in:0,1'],
        ];        
        
        if(isset($this->File)){            
            $rules['File'] = ['nullable', 'mimes:csv,txt'];
        } else {                  
            if(!isset($this->email) || count($this->email) <= 0 || (count($this->email) == 1 && in_array(null, $this->email))) {                   
                $rules['email'] = [function ($attribute, $value, $fail) {                    
                    if (!isset($this->email) || count($this->email) <= 0 || count($this->email) == 1  && in_array(null, $this->email)) {
                        $fail('Vui lòng chọn Danh sách người nhận');
                    }                                        
                }];
            } 
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập danh sách người nhận',
            // 'email.email' => 'Email người nhận không đúng định dạng',
            // 'email.max' => 'Thông tin phải có tối đa 255 ký tự',
            'title.required' => 'Vui lòng nhập đầy đủ Tiêu đề',
            'title.min' => 'Độ dài Tiêu đề tối thiểu 8 ký tự',
            'title.max' => 'Độ dài Tiêu đề tối đa 150 ký tự',  
            'content.required' => 'Vui lòng nhập đầy đủ Nội dung',
            'content.min' => 'Độ dài Nội dung tối thiểu 8 ký tự',
            'obj_types.required' => 'Vui lòng chọn đối tượng nhận: Thí sinh mới, Sinh viên, Nhân sự',
            'obj_types.in' => 'Vui lòng chọn đúng đối tượng gửi thông báo: 0: Thí sinh mới, 1: Sinh viên, 2: Nhân sự',
            'obj_types.required' => 'Vui lòng chọn đối tượng nhận: Thí sinh mới, Sinh viên, Nhân sự',            
            'status.in' => 'Vui lòng chọn đúng trạng thái: 0: Nháp, 1: Đã gửi',
            'File.mimes' => 'File import không đúng định dạng: xlsx, xls, txt'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
