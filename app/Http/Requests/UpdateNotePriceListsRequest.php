<?php

namespace App\Http\Requests;

use App\Models\Leads;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateNotePriceListsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {       
        return [         
            "note"          => ["required", "max:255" ]
        ];
    }

    public function messages()
    {
        return [            
            'note.required'                    => 'Vui lòng nhập nội dung ghi chú',
            'note.max'                         => 'Độ dài tối đa 255 ký tự'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
