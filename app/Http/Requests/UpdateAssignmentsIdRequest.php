<?php

namespace App\Http\Requests;

use App\Models\Employees;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAssignmentsIdRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'assignments_id' => ['nullable',  function ($attribute, $value, $fail) {     
                $model = Employees::where('id', $value)->first();
                if (!isset($model->id)) {
                    $fail('Tư vấn viên không tồn tại trên hệ thống');
                }
            }],           
        ];
    }

    public function messages()
    {
        return [
            'leads_id.required' => 'Vui lòng chọn tư vấn viên'            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
