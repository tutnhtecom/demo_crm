<?php

namespace App\Http\Requests;

use App\Models\CustomFieldImports;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateCustomFieldImportsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {   
        return [                        
            "name"          => ['required'],
            "types"         => ['nullable' , function ($attribute, $value, $fail) {
                if(!in_array(1, CustomFieldImports::LIST_TYPE)){
                    $fail('Đối tượng này không tồn tại');
                }                
            }],
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'Vui lòng nhập tên trường bổ sung'            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
