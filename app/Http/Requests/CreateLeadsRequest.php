<?php

namespace App\Http\Requests;

use App\Models\AcademicTerms;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Employees;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\Sources;
use App\Models\User;

class CreateLeadsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {      
        $marjors_id = $this->marjors_id;                
        return [        
            'leads_code'    => ['nullable', function ($attribute, $value, $fail) use($marjors_id){
                $leads_code_unique = Leads::where('leads_code', $value)->count();                  
                if ($leads_code_unique > 0) {
                    $fail('Mã số sinh viên ' . $value . ' đã tồn tại');
                }
            }],    
            'full_name'     => ['required','max:255', 'min:1'],     
            'phone'         => ['required','regex:/^(\d{10}|\d{11}|\d{12})$/', function ($attribute, $value, $fail) use($marjors_id){
                $eLeadsUnique = Leads::where('phone', $value)->where('marjors_id', $marjors_id)->count();                                
                if ($eLeadsUnique > 0) {
                    $fail('Thí sinh đã tồn tại trên hệ hống');
                }
            }],    
            'email'         => ['required','max:255', 'email', function ($attribute, $value, $fail) use($marjors_id) {
                $eLeadsUnique = Leads::where('email', $value)->where('marjors_id', $marjors_id)->count();
                if ($eLeadsUnique > 0) {
                    $fail('Thí sinh đã tồn tại trên hệ hống');
                }
            }],     
            'gender'        => ['nullable','regex:/^[012]+$/'],   
            'date_of_birth' => ['nullable', 'date_format:d/m/Y',
            function ($attribute, $value, $fail) {                
                if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                    $fail('Ngày sinh phải nhỏ hơn ngày hôm nay');
                }
            }],                        
            // 'identification_card'       => ['nullable', 'size:12', 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/', function ($attribute, $value, $fail) use($marjors_id) {
            //     $eLeadsUnique = Leads::where('phone', $value)->where('marjors_id', $marjors_id)->count();
            //     if ($eLeadsUnique > 0) {
            //         $fail('Thí sinh đã tồn tại trên hệ hống');
            //     }
            // }],
            'identification_card'       => ['nullable', 'size:12', function ($attribute, $value, $fail) use($marjors_id) {
                $eLeadsUnique = Leads::where('phone', $value)->where('marjors_id', $marjors_id)->count();
                if ($eLeadsUnique > 0) {
                    $fail('Thí sinh đã tồn tại trên hệ hống');
                }
            }],

            "lst_status_id" =>['required', function ($attribute, $value, $fail) {
                $status = LstStatus::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Trạng thái không tồn tại trên hệ thống');
                }
            }],

            "sources_id" =>['required', function ($attribute, $value, $fail) {
                $status = Sources::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nguồn tiếp cận không tồn tại trên hệ thống');
                }
            }],

            "employees_id" =>['required', function ($attribute, $value, $fail) {
                $status = Employees::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],

            "marjors_id" =>['required', function ($attribute, $value, $fail) {
                $status = Marjors::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Chuyên ngành không tồn tại trên hệ thống');
                }
            }],
            "academic_terms_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = AcademicTerms::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Niên khóa không tồn tại trên hệ thống');
                }
            }],
            
        ];
        // return $rules;
    }

    public function messages()
    {
        return [
            'full_name.required'                => 'Vui lòng nhập Họ và tên',
            'full_name.min'                     => 'Họ và tên phải có ít nhất 1 ký tự',
            'full_name.max'                     => 'Họ và tên phải có tối đa 255 ký tự',  
            
            'phone.required'                    => 'Vui lòng nhập Số điện thoại',            
            'phone.unique'                      => 'Số điện thoại đã tồn tại', 
            'phone.regex'                       => 'Số điện thoại không đúng định dạng', 
            'identification_card.size'          => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            'email.required'                    => 'Vui lòng nhập Email ',            
            'email.unique'                      => 'Email này đã tồn tại', 
            'email.max'                         => 'Độ dài email tối đa 255 ký tự',  
            'email.email'                       => 'Email không đúng định dạng',          
            // 'gender.required'                => 'Vui lòng nhập Giới tính ', 
            'gender.regex'                      => 'Giá trị của giới tính thuộc 1 trong các giá trị [0, 1, 2]',    
            'date_of_birth.required'            => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date_format'         => 'Ngày sinh không đúng định dạng d/m/Y',
            'lst_status_id.required'            => 'Vui lòng chọn Tình trạng tư vấn',
            'sources_id.required'               => 'Vui lòng chọn Nguồn',
            'marjors_id.required'               => 'Vui lòng chọn Ngành học',
            'employees_id'                      => 'Vui lòng chọn Tư vấn viên',
            
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        // throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }   
}
