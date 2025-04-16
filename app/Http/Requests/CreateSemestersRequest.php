<?php

namespace App\Http\Requests;

use App\Models\AcademicTerms;
use App\Models\Semesters;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSemestersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'name'                  => ['required','max:255', 'min:1', 'unique:semesters,name'],              
            'from_date'             => ['nullable', 'date_format:d/m/Y'],              
            'to_date'               => ['nullable', 'date_format:d/m/Y', 'after_or_equal:from_date'],   
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
            'name.required'                 => 'Vui lòng nhập đầy đủ thông tin',
            'name.min'                      => 'Thông tin phải có ít nhất 1 ký tự',
            'name.max'                      => 'Thông tin phải có tối đa 255 ký tự',              
            'name.unique'                   => 'Thông tin đã tồn tại trên hệ thống',   

            'from_date.date_format'         => 'Ngày bắt đầu chưa đúng định dạng d/m/Y',
            'to_date.date_format'           => 'Ngày kết thúc chưa đúng định dạng d/m/Y',
            'to_date.after_or_equal'        => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',

            'academic_terms_name.required'  => 'Vui chọn niên khóa cho học kỳ',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
