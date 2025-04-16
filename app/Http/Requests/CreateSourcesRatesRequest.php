<?php

namespace App\Http\Requests;

use App\Models\AcademicTerms;
use App\Models\Semesters;
use App\Models\Sources;
use App\Models\SourcesDocuments;
use App\Models\SourcesRates;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSourcesRatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {   
        $rules = [
            "sources_id" => ['required', function ($attribute, $value, $fail) {
                $dem = Sources::where('id', $value)->count();                
                if ($dem <= 0) {
                    $fail('Đơn vị liên kết không tồn tại');
                }
            }],          
            "sources_documents_id" => ['required', function ($attribute, $value, $fail) {
                $dem = SourcesDocuments::where('sources_id', $this->sources_id)->where('id', $value)->count();                
                if ($dem <= 0) {
                    $fail('Hợp đồng không tồn tại');
                }
            }],
            "academic_terms_id" => ['nullable', function ($attribute, $value, $fail) {
                $dem = AcademicTerms::where('id', $value)->count();
                if ($dem <= 0) {
                    $fail('Niên khoá không tồn tại');
                }
            }],
            "expense_name" => ['required'],
            "payment_condition" => ['nullable'],
            "math_sign" => ['nullable'],
            "payment_rate" => ['nullable'],                        
            "payment_manager_rate" => ['nullable'],
            "payment_manager_price" => ['nullable'],
            "payment_note" => ['required'],
        ];
        
        // if($this->is_single == 1) {
        //     $rules["semesters_id"] = ['required', function ($attribute, $value, $fail) {
        //         $dem = Semesters::where('academic_terms_id', $this->academic_terms_id)->where('id', $value)->count();                
        //             if ($dem <= 0) {
        //                 $fail('Học kỳ không thuộc niên khoá này');
        //         }
        //     }];
        // }             
        return $rules;        
    }

    public function messages()
    {        
        $msg = [
            "sources_id.required"           => "Vui lòng chọn Đơn vị liên kết",
            "sources_document_id.required"  => "Vui lòng chọn Hợp đồng",
            // "academic_terms_id.required"    => "Vui lòng chọn Niên khoá",            
            "expense_name.required"         => "Vui lòng nhập Khoản chi",
            "payment_condition.required"    => "Vui lòng nhập Điều kiện thanh toán",
            "math_sign.required"            => "Vui lòng chọn toán tử: <, >=",
            "payment_rate.required"         => "Vui lòng nhập tỷ lệ cho Định mức thanh toán cho ĐVLK",
            "payment_manager_rate.required" => "Vui lòng nhập tỷ lệ cho Định mức thanh toán cho CB Quản lý",
            "payment_manager_price.required"=> "Vui lòng nhập Định mức thanh toán cho Cán bộ quản lý",
            "payment_note.required"         => "Vui lòng nhập Thời gian thực hiện thanh toán",
        ];
        if($this->is_single == 1) {            
            $msg["semesters_id.required" ] = "Vui lòng chọn Học kỳ";
        }
        return $msg;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));
    }
}
