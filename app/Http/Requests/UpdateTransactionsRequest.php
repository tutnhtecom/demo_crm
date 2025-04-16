<?php

namespace App\Http\Requests;

use App\Models\Leads;
use App\Models\PriceLists;
use App\Models\TransactionStatus;
use App\Models\TransactionTypes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTransactionsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [   
            'code'        => ['nullable', "min:6", "max:150", 'unique:transactions,code,' . $this->id],
            'leads_id'    => ['required', 
            function ($attribute, $value, $fail) {               
                $model = Leads::where('id', $value)->first();
                if (!isset($model->id)) {                    
                    $fail('Thi sinh không tồn tại trên hệ thống');                
                }   
               
            }],
            "name"              => ["required", "max:255", "min: 8" ],
            "tran_status_id"    => ["required", function ($attribute, $value, $fail) {               
                $model = TransactionStatus::where('id', $value)->first();
                if (!isset($model->id)) {                    
                    $fail('Trạng thái giao dịch không tồn tại trên hệ thống');                
                }   
               
            }],
            "price_lists_id"    => ["nullable", function ($attribute, $value, $fail) {               
                $model = PriceLists::where('id', $value)->first();
                if (!isset($model->id)) {                    
                    $fail('Hóa đơn này giao dịch không tồn tại trên hệ thống');                
                }   
               
            }],
            "tran_types_id"    => ["nullable", function ($attribute, $value, $fail) {               
                $model = TransactionTypes::where('id', $value)->first();
                if (!isset($model->id)) {                    
                    $fail('Loại giao dịch không tồn tại trên hệ thống');                
                }                  
            }],
            "price"       => ["required", "numeric" ],
            "tran_date"   => ["required", "date_format:d/m/Y", "before_or_equal:now"],           
            "tran_time"   => ["nullable", "date_format:H:i"],
            "note"        => ["nullable", "max:255" ]
        ];
    }

    public function messages()
    {
        return [
            'code.required'               => 'Vui lòng nhập Tên giao dịch',            
            'code.max'                    => 'Độ dài tối đa 155 ký tự',      
            'code.min'                    => 'Độ dài tối thiểu 6 ký tự',     
            'code.unique'                 => 'Mã giao dịch đã tồn tại trên hệ thống',     
            'leads_id.required'           => 'Vui lòng chọn Thí sinh',
            'name.required'               => 'Vui lòng nhập Tên giao dịch',            
            'name.max'                    => 'Độ dài tối đa 255 ký tự',      
            'name.min'                    => 'Độ dài tối thiểu 8 ký tự',      
            'tran_status_id.required'     => 'Vui lòng chọn Trạng thái giao dịch',
            'tran_types_id.required'      => 'Vui lòng chọn Loại giao dịch',            
            'price.required'              => 'Vui lòng nhập học phí',
            'price.numeric'               => 'Học phí phải là dạng số',
            'tran_date.required'          => 'Vui lòng nhập Ngày giao dịch',
            'tran_date.date_format'       => 'Ngày giao dịch không đúng định đạng: DD/MM/YYYY',
            'tran_date.before_or_equal'   => 'Ngày giao dịch phải nhỏ hoặc bằng Ngày hiện tại',
            'tran_time.required'          => 'Vui lòng nhập thời gian giao dịch',
            'tran_time.date_format'       => 'Thời gian giao dịch không đúng định đạng: H:i',
            'note.max'                    => 'Độ dài tối đa 255 ký tự'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();         
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
