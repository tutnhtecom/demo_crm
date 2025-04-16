<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadFileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {       
        return [                        
            'images' => ['required', 'max:16375', 'mimes:jpg,jpeg,png,gif,zip,rar'],         
        ];
    }

    public function messages()
    {
        return [
            'images.required' => 'Vui lòng tải các file cần thiết',            
            'images.max'      => 'Dung lượng không vượt quá 16MB',              
            // 'image.image'    => 'File tải lên không phải là ảnh',
            'images.mimes'    => 'File không đúng định dạng'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
