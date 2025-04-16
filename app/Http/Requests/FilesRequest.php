<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class FilesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
           'file' => ['required','file','mimes:xlsx,xls','max:16375'],         
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'Vui lòng chọn file import',
            'file.mimes'    => 'File Import không đúng định dạng: xlsx, xls',
            'file.max'      => 'Dung lượng file lớn hơn 16MB',              
            'file.file'     => 'File import không đúng định dạng',   
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
