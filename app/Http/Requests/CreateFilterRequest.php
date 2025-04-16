<?php

namespace App\Http\Requests;

use App\Models\ConfigFilter;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'name'      => ['required', function ($attribute, $value, $fail){
                $dem    = ConfigFilter::where('name', $value)->count();                  
                if ($dem > 0) {
                    $fail('Tên bộ lọc đã tồn tại trên hệ thống');
                }
            }],
            'start_date'=> ['required', 'date_format:d/m/Y'],
            'end_date'  => ['required', 'date_format:d/m/Y', "after_or_equal:start_date"],
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập tên bộ lọc.',
            'start_date.required'       => 'Vui lòng nhập thời gian bắt đầu.',
            'start_date.date_format'    => 'Ngày bắt đầu không đúng định dạng d/m/Y',
            'end_date.required'         => 'Vui lòng nhập ngày kết thúc.',
            'end_date.date_format'      => 'Ngày kết thúc phải có định dạng d/m/Y',
            'end_date.after_or_equal'   => 'Ngày kết thúc phải lớn hơn ngày bắt đầu',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
