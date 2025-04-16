<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\Sources;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateStudentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(){
        $rules = [
            'full_name'     => ['required','max:255', 'min:1'],     
            'phone'         => ['required','regex:/^(\d{10}|\d{11}|\d{12})$/', 'unique:leads,phone,' . $this->id],
            'email'         => ['required','max:255', 'email', 'unique:students,email'],     
            'gender'        => ['required','regex:/^[012]+$/'],   
            'date_of_birth' => ['required', 'date_format:d/m/Y','before:now' ],
            'identification_card'       => ['required', 'size:12', 'unique:students,identification_card,' . $this->id, 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/'],
            "lst_status_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = LstStatus::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Trạng thái không tồn tại trên hệ thống');
                }
            }],

            "sources_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = Sources::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nguồn tiếp cận không tồn tại trên hệ thống');
                }
            }],

            "employees_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = Employees::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],

            "marjors" =>['nullable', function ($attribute, $value, $fail) {
                $status = Marjors::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Chuyên ngành không tồn tại trên hệ thống');
                }
            }],
        ];


        return $rules;
    }

    public function rules1()
    {   
        return [                        
            'full_name'     => ['required','max:255', 'min:1'],     
            'phone'         => ['required','regex:/^(\d{10}|\d{11}|\d{12})$/', 'unique:leads,phone,' . $this->id],
            'email'         => ['required','max:255', 'email', 'unique:students,email'],     
            'gender'        => ['required','regex:/^[012]+$/'],   
            'date_of_birth' => ['required', 'date_format:d/m/Y',
            function ($attribute, $value, $fail) {                
                if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                    $fail('Ngày sinh phải nhỏ hơn ngày hôm nay');
                }
            }],
            'identification_card'       => ['required', 'size:12', 'unique:students,identification_card,' . $this->id, 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/'],
            "lst_status_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = LstStatus::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Trạng thái không tồn tại trên hệ thống');
                }
            }],

            "sources_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = Sources::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nguồn tiếp cận không tồn tại trên hệ thống');
                }
            }],

            "employees_id" =>['nullable', function ($attribute, $value, $fail) {
                $status = Employees::where('id', $value)->first();
                if (!isset($status->id)) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],

            "marjors" =>['nullable', function ($attribute, $value, $fail) {
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
            'date_of_birth.before'      => 'Ngày sinh phải nhỏ hơn ngày hiện tại',
            
            // CCCD
            'identification_card.required'      => 'Vui lòng nhập Căn cước công dân',
            'identification_card.size'          => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            'identification_card.regex'         => 'Căn cước công dân không đúng định dạng',
            'identification_card.unique'        => 'Căn cước công dân đã tồn tại trên hệ thống',
        ];
    }

    protected function failedValidation(Validator $validator){
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }   
}
