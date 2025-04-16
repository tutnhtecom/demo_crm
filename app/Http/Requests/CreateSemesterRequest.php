<?php

namespace App\Http\Requests;

use App\Models\AcademyList;
use App\Models\DVLKSemesters;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSemesterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            "academy_id"        => ['required', function ($attribute, $value, $fail) {
                $dem = AcademyList::where('id', $value)->count();                
                if ($dem <= 0) {
                    $fail('Khóa ' . $value . " không tồn tại trên hệ thống");
                }
            }],
            "semesters_name"    => ['required','max:255', 'min:1', function ($attribute, $value, $fail) {
                $dem = DVLKSemesters::where('semesters_name', $value)->where('academy_id', $this->academy_id)->count();                
                if ($dem > 0) {
                    $fail($value . " đã tồn tại trên hệ thống");
                }
            }],
            "semesters_year"    => ['required'],
            "admission_date"    => ['required'],
            // "types"             => ['in:0,1'],
        ];
    }

    public function messages()
    {
        return [
            'academy_id.required'           => 'Vui lòng chọn khóa tuyển sinh',
            'semesters_name.required'       => '',
            'semesters_name.min'            => 'Thông tin phải có ít nhất 1 ký tự',
            'semesters_name.max'            => 'Thông tin phải có tối đa 255 ký tự',
            "semesters_year.required"       => 'Vui lòng chọn năm tuyển sinh',
            'admission_date.date_format'    => 'Ngày khai giảng chưa đúng định dạng d/m/Y',
            "admission_date.required"       => 'Vui lòng chọn ngày khai giảng',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
