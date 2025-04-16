<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateApiListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'name'          => ['required', 'max:255', 'min:8'],
            'request_url'   => ['required', 'unique:api_lists,request_url,' . $this->id, 'min:1'],
            'method_name'   => ['required', 'min:1'],
            "body"          => ['required'], 
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Vui lòng nhập tên của API',
            'name.min'              => 'Độ dài tối thiểu 8 ký tự',
            'name.max'              => 'Độ dài tối đa 255 ký tự',            

            'request_url.required'  => 'Vui lòng nhập Request URL',
            'request_url.min'       => 'Độ dài tối thiểu 1 ký tự',       
            'request_url.unique'    => 'Request URL đã tồn tại trên hệ thống',     

            'method_name.required'  => 'Vui lòng nhập Phương thức',            
            'method_name.min'       => 'Độ dài tối thiểu 1 ký tự', 

            'body.required'         => 'Vui lòng nhập đầy đủ Môn xét tuyển',            
            'body.min'              => 'Môn xét tuyển phải có tối đa 255 ký tự',     
            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
