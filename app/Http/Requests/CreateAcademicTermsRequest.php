<?php

namespace App\Http\Requests;

use App\Models\AcademicTerms;
use App\Models\Employees;
use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateAcademicTermsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name'          => ['required', 'max:255', 'min:1',function ($attribute, $value, $fail) {
                $dem = AcademicTerms::where('name', 'like', '%'.$value.'%')->count();
                if($dem > 0){
                    $fail("Niên khóa đã tồn tại trên hệ thống");
                }                
            }],
            'from_year'     => ['required', 'numeric'],  
            // 'to_year'       => ['nullable', 'numeric'],  
            // 'note'          => ['nullable', 'min:1'],  
        ];
    }
    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập Tên niên khóa',
            'name.min'                  => 'Tên niên khóa phải có ít nhất 1 ký tự',
            'name.max'                  => 'Tên niên khóa phải có tối đa 255 ký tự',  
            'from_year.required'        => 'Vui lòng nhập Năm bắt đầu',
            'from_year.numeric'         => 'Năm bắt đầu không đúng định dạng số',

            // 'to_year.required'          => 'Vui lòng nhập Năm kết thúc',
            // 'to_year.numeric'           => 'Năm kết thúc không đúng định dạng số',
            // 'to_year.after_or_equal'    => 'Năm kết thúc phải lớn hơn năm bắt đầu', 

            // 'note.min'                  => 'Độ dài mô tả tối thiểu 1 ký tự',          
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }   
}
