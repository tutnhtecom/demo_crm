<?php

namespace App\Http\Requests;

use App\Models\Leads;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdatePriceListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [
            "leads_id"      => ["required",  function ($attribute, $value, $fail) {                                       
                $model = Leads::whereIn('id', $value)->get()->toArray();                
                if (count($model) < count($value)) {
                    $fail('Thí sinh này không tồn tại trên hệ thống');
                }
            }],          
            "title"         => ["required", "max:255", "min: 8" ],
            "price"         => ["required", "numeric" ],
            "from_date"     => ["required", "date_format:d/m/Y", "after_or_equal:now"],           
            "to_date"       => ["required", "date_format:d/m/Y", "after_or_equal:from_date" ],
            "note"          => ["nullable", "max:255" ]
        ];
    }

    public function messages()
    {
        return [ 
            'leads_id.required'                 => 'Vui lòng chọn thí sinh',           
            'title.required'                    => 'Vui lòng nhập tiêu đề báo giá',            
            'title.max'                         => 'Độ dài tối đa 255 ký tự',      
            'title.min'                         => 'Độ dài tối thiểu 8 ký tự',            
            'price.required'                    => 'Vui lòng nhập học phí',
            'price.numeric'                     => 'Học phí phải là dạng số',
            'from_date.required'                => 'Vui lòng nhập ngày bắt đầu hạn nộp',
            'from_date.date_format'             => 'Ngày bắt đầu hạn nộp không đúng định đạng: DD/MM/YYYY',
            'from_date.after_or_equal'          => 'Ngày bắt đầu hạn nộp phải lớn hơn hoặc bằng ngày hiện tại',
            'from_date.required'                => 'Vui lòng nhập ngày kết thúc hạn nộp',
            'to_date.date_format'             => 'Ngày bắt đầu hạn nộp không đúng định đạng: DD/MM/YYYY',
            'to_date.after_or_equal'          => 'Ngày bắt đầu hạn nộp phải lớn hơn hoặc bằng ngày bắt đầu',
            'note.max'                         => 'Độ dài tối đa 255 ký tự'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
