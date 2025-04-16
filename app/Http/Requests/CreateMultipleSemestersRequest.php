<?php

namespace App\Http\Requests;

use App\Models\AcademicTerms;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateMultipleSemestersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [    
            "academic_terms_name"   => ['required', function ($attribute, $value, $fail) {
                $dem = AcademicTerms::where('name', 'LIKE', '%'.$value.'%')->count();
                
                if ($dem <= 0) {
                    $fail('Niên khóa không tồn tại trên hệ thống');
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'academic_terms_name.required'  => 'Vui chọn niên khóa cho học kỳ',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
