<?php

namespace App\Http\Requests;

use App\Models\Leads;
use App\Models\NotificationsGroups;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePriceListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {       
        $today = Carbon::today()->format('d/m/Y');  
        $rules["title"] = ["required", "max:255", "min: 1" ];
        $rules["price"] = ["required", "numeric" ];                
        $rules["note"] = ["nullable", "max:255"];
        $rules["from_date"] = ["required", "date_format:d/m/Y"];
        $rules["to_date"] = ["required", "date_format:d/m/Y", "after_or_equal:from_date"]; 
        if(isset($this->groups_id)) {
            $rules['groups_id'] = ["required", function ($attribute, $value, $fail) {
                $groups = NotificationsGroups::where('id', $value)->count();
                if($groups <= 0) {
                      $fail("Nhóm thông báo không tồn tại");
                }
            }];
        } else {
            $rules['leads_id'] = ['required', function ($attribute, $value, $fail) {
                $leads = Leads::where('id', $value)->count();
                if($leads <= 0) {
                     $fail("Thí sinh không tồn tại trên hệ thống");
                }
             }];
        }                        
        // if(isset($this->File) && $this->File != 'undefined'){
        //     $file = $_FILES['File']['name'];  // Lấy tên tệp từ form upload
        //     $file_info = pathinfo($file);
        //     $file_extension = $file_info['extension'];  // Lấy phần mở rộng của tệp            
        //     $rules['File'] = ['nullable', 'file', 'max:15048',  function ($attribute, $value, $fail) use ($file_extension){
        //         if($file_extension != 'pdf') {
        //             $fail("File không đúng định dạng PDF");
        //         }
        //     }];
        // } 
        return $rules;
    }

    public function messages()
    {
        return [
            'leads_id.required'                 => 'Vui lòng chọn Thí sinh',
            'title.required'                    => 'Vui lòng nhập tiêu đề báo giá',            
            'title.max'                         => 'Độ dài tối đa 255 ký tự',      
            'title.min'                         => 'Độ dài tối thiểu 1 ký tự',            
            'price.required'                    => 'Vui lòng nhập học phí',
            'price.numeric'                     => 'Học phí phải là dạng số',
            'from_date.required'                => 'Vui lòng nhập ngày bắt đầu hạn nộp',
            'from_date.date_format'             => 'Ngày bắt đầu hạn nộp không đúng định đạng: DD/MM/YYYY',            
            'to_date.required'                  => 'Vui lòng nhập ngày kết thúc hạn nộp',
            'to_date.date_format'               => 'Ngày kết thúc hạn nộp không đúng định đạng: DD/MM/YYYY',            
            'to_date.after_or_equal'            => 'Ngày kết thúc phải lớn hơn hoặc ngày bắt đầu',                        
            'note.max'                          => 'Độ dài tối đa 255 ký tự',            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();             
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
        
    }
}
