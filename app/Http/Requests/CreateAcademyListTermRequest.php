<?php

namespace App\Http\Requests;

use App\Models\AcademyList;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class CreateAcademyListTermRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'academy_list_id'    => ['required'],
            'admission_year'     => ['required', 'numeric','max:4', 'min:4'],  
            'admission_semester' => ['required', 'max:50', 'min:1'],  
            'opening_day'        => ['required', 'date_format:d/m/Y', 'after:'. Carbon::now()->format('d/m/Y')],
        ];
    }

    public function messages()
    {
        return [
            'academy_list_id.required'  => 'Vui lòng chọn Khóa tuyển sinh',

            'admission_year.required'   => 'Vui lòng nhập Năm tuyển sinh',
            'admission_year.numeric'    => 'Năm tuyển sinh không đúng định dạng số',
            'admission_year.max'        => 'Năm tuyển sinh không đúng định dạng',
            'admission_year.min'        => 'Năm tuyển sinh không đúng định dạng',

            'admission_semester.required' => 'Vui lòng nhập Học kỳ nhập học',
            'admission_semester.max'      => 'Học kỳ nhập học không đúng định',
            'admission_semester.min'      => 'Học kỳ nhập học không đúng định',

            'opening_day.required'      => 'Vui lòng nhập Ngày khai giảng',
            'opening_day.date_format'   => 'Ngày khai giảng không đúng định dạng d/m/Y',           
            'opening_day.after'         => 'Ngày khai giảng phải lớn hơn ngày hiện tại',              
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }  
}
