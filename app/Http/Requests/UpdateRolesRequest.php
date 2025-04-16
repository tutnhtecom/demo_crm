<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRolesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'name' => ['required','max:255', 'min:1', 'unique:roles,name,' . $this->id],  
            'slug' => ['nullable','max:255', 'min:1', 'unique:roles,slug,' . $this->id],  
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập đầy đủ Vai trò',
            'name.min'      => 'Vai trò phải có ít nhất 1 ký tự',
            'name.max'      => 'Vai trò phải có tối đa 255 ký tự',              
            'name.unique'   => 'Vai trò đã tồn tại trên hệ thống',   
            
            'slug.min'      => 'Vai trò phải có ít nhất 1 ký tự',
            'slug.max'      => 'Vai trò phải có tối đa 255 ký tự',              
            'slug.unique'   => 'Vai trò đã tồn tại trên hệ thống', 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
