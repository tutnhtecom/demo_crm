<?php

namespace App\Http\Requests;

use App\Models\Sources;
use App\Models\SourcesRates;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\AcademicTerms;
use App\Models\Semesters;

use App\Models\SourcesDocuments;
class UpdateSourcesRatesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            "sources_id" => ['required', function ($attribute, $value, $fail) {
                $dem = Sources::where('id', $value)->count();
                if ($dem <= 0) {                    
                    $fail('Đơn vị liên kết không tồn tại');                
                }
            }],
            "sources_documents_id" => ['required', function ($attribute, $value, $fail) {
                $dem = SourcesDocuments::where('sources_id', $this->sources_id)->where('id', $value)->count();                
                if ($dem <= 0) {
                    $fail('Hợp đồng ký kết không tồn tại');
                }
            }],
            "semesters_id" => ['required'],
            "expense_name" => ['required'],
            "payment_condition" => ['required'],
            "math_sign" => ['required'],
            "payment_rate" => ['required'],                        
            "payment_manager_rate" => ['required'],
            "payment_manager_price" => ['required'],
            "payment_note" => ['required'],
        ];
    }

    public function messages()
    {
        return [            
            "sources_id.required"           => "Vui lòng chọn Đơn vị liên kết",
            "sources_document_id.required"  => "Vui lòng chọn Hợp đồng",
            // "academic_terms_id.required"    => "Vui lòng chọn Niên khoá",
            "semesters_id.required"         => "Vui lòng chọn Học kỳ",
            "expense_name.required"         => "Vui lòng nhập Khoản chi",
            "payment_condition.required"    => "Vui lòng nhập Điều kiện thanh toán",
            "math_sign.required"            => "Vui lòng chọn toán tử: <, >=",
            "payment_rate.required"         => "Vui lòng nhập tỷ lệ cho Định mức thanh toán cho ĐVLK",
            "payment_manager_rate.required" => "Vui lòng nhập tỷ lệ cho Định mức thanh toán cho CB Quản lý",
            "payment_manager_price.required"=> "Vui lòng nhập Định mức thanh toán cho Cán bộ quản lý",
            "payment_note.required"         => "Vui lòng nhập Thời gian thực hiện thanh toán",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
