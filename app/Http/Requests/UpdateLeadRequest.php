<?php

namespace App\Http\Requests;


use App\Models\Employees;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\Sources;
use App\Models\User;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateLeadRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {   
        return [            
            'leads_code'    => ['nullable', function ($attribute, $value, $fail){
                $leads_code_unique = Leads::where('id', '!=' , $this->id)
                                    ->where('leads_code', $value)
                                    ->count();                    
                if ($leads_code_unique > 0) {
                    $fail('Mã số sinh viên ' . $value . ' đã tồn tại');
                }
            }],
            'full_name'     => ['required','max:255', 'min:1'],
            'phone'         => ['required','regex:/^(\d{10}|\d{11}|\d{12})$/', function ($attribute, $value, $fail) {                
                if(strlen($value) > 0) {
                    $dem = Leads::where('id', '!=' , $this->id)
                            ->where('phone', $value)->where('marjors_id', $this->marjors_id)->count();                    
                    if ($dem > 0) {
                        $fail('Số điện thoại đã tồn tại trên hệ thống');
                    }
                }
             }],
            'email'         => ['required','max:255', 'email', function ($attribute, $value, $fail) {
                $eLeadsUnique = Leads::where('id', '!=' , $this->id)
                                ->where('email', $value)
                                ->where('marjors_id', $this->marjors_id)->count();
                if ($eLeadsUnique > 0  || $value == $this->get_email_admin()) {
                    $fail('Email đã được đăng ký trên hệ thống');
                }
            }],
            'gender'        => ['nullable','regex:/^[012]+$/'],
            'date_of_birth' => ['nullable', 'date_format:d/m/Y',
            function ($attribute, $value, $fail) {
                if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                    $fail('Ngày sinh phải nhỏ hơn ngày hôm nay');
                }
            }],
            "identification_card"       => ['nullable', 'size:12'],
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
      
        ];
    }

    public function messages()
    {
        return [
            'full_name.required'        => 'Vui lòng nhập Họ và tên',
            'full_name.min'             => 'Họ và tên phải có ít nhất 1 ký tự',
            'full_name.max'             => 'Họ và tên phải có tối đa 255 ký tự',

            'phone.required'            => 'Vui lòng nhập Số điện thoại',
            'phone.unique'              => 'Số điện thoại đã tồn tại',
            'phone.regex'               => 'Số điện thoại không đúng định dạng',

            'email.required'            => 'Vui lòng nhập Email ',
            'email.unique'              => 'Email này đã tồn tại',
            'email.max'                 => 'Độ dài email tối đa 255 ký tự',
            'email.email'               => 'Email không đúng định dạng',
            'gender.required'           => 'Vui lòng nhập Giới tính ',
            'gender.regex'              => 'Giá trị của giới tính thuộc 1 trong các giá trị [0, 1, 2]',
            'date_of_birth.required'    => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date_format' => 'Ngày sinh không đúng định dạng d/m/Y',
            // CCCD
            'identification_card.required'      => 'Vui lòng nhập Căn cước công dân',
            'identification_card.size'          => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            'identification_card.regex'         => 'Căn cước công dân không đúng định dạng',
            'identification_card.unique'        => 'Căn cước công dân đã tồn tại trên hệ thống',
            'lst_status_id'                     => 'Vui lòng chọn Tình trạng tư vấn',
            'sources_id'                        => 'Vui lòng chọn Nguồn',
            'employees_id'                      => 'Vui lòng chọn Tư vấn viên',
            'marjors_id'                        => 'Vui lòng chọn Ngành học',
          
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));
    }
}
