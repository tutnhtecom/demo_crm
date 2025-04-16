<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DashboardFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
           "from_date"     => ["nullable", "date_format:d/m/Y"],           
           "to_date"       => ["nullable", "date_format:d/m/Y", "after_or_equal:from_date"],
        ];
    }

    public function messages()
    {
        return [            
            'from_date.date_format' => 'Thời gian bắt đầu không đúng định dạng',
            
            'to_date.date_format' => 'Thời gian kết thúc không đúng định dạng',
            'to_date.after_or_equal' => 'Thời gian kết không được lớn hơn thời gian bắt đầu',             
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
