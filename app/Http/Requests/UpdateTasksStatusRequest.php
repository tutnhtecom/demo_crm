<?php

namespace App\Http\Requests;

use App\Models\Tasks;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTasksStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {  
        return [                        
            'status' => ['required', function ($attribute, $value, $fail) {                                
                if (!in_array($value, Tasks::STATUS_MAP_ID)) {
                    $fail('Trạng thái không tồn tại');
                }
            }],       
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập đầy đủ thông tin',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
