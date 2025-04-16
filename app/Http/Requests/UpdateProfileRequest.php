<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {   
        return [                        
            'avatar' => ['required'],
            'date_of_birth' => ['nullable', 'date_format:d/m/Y',
            function ($attribute, $value, $fail) {                
                if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                    $fail('Ngày sinh phải nhỏ hơn ngày hôm nay');
                }
            }],
            "place_of_birth"            => ['required'],
            "type_id_tdvh"              => ['required'],
            "type_id_tdcm"              => ['required'],
            "nations_name"              => ['required'],
            "ethnics_name"              => ['required'],
            'identification_card'       => ['nullable', 'size:12', 'unique:leads,identification_card,' . $this->id, 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/'],            
            'date_identification_card'  => ['nullable', 'date_format:d/m/Y',
                function ($attribute, $value, $fail) {
                    if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                        $fail('Ngày cấp phải nhỏ hơn ngày hôm nay');
                    }
                }],
            "place_identification_card" => ['nullable'],
            "date_of_join_youth_union"  => ['nullable',
                function ($attribute, $value, $fail) {
                    if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                        $fail('Ngày kết nạp đoàn phải nhỏ hơn ngày hôm nay');
                    }
            }],
            "date_of_join_communist_party"  => ['nullable',
                function ($attribute, $value, $fail) {
                    if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') >= date('Y-m-d')) {
                        $fail('Ngày vào đang phải nhỏ hơn ngày hôm nay');
                    }
            }],
            "email" => ['nullable', 'email'],

            "year_of_degree_tdvh" => ['required', 
                function ($attribute, $value, $fail) {
                if (Carbon::createFromFormat('Y', $value)->format('Y') > date('Y')) {
                $fail('Năm cấp bằng phải nhỏ hơn năm hiện tại');
                }
            }],
            "date_of_degree_tdvh" => ['required', 
                function ($attribute, $value, $fail) {
                    if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') > date('Y-m-d')) {
                        $fail('Ngày cấp bằng phải nhỏ hơn ngày hôm nay');
                    }
            }],
            "serial_number_degree_tdvh" => ['required'],          
            "place_of_degree_tdvh" => ['required'],          
            "year_of_degree_tdcm" => ['required', 
                function ($attribute, $value, $fail) {
                if (Carbon::createFromFormat('Y', $value)->format('Y') > date('Y')) {
                $fail('Năm cấp bằng phải nhỏ hơn năm hiện tại');
                }
            }],
            "date_of_degree_tdcm" => ['required', 
                function ($attribute, $value, $fail) {
                    if (Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') > date('Y-m-d')) {
                        $fail('Ngày cấp bằng phải nhỏ hơn ngày hôm nay');
                    }
            }],
            "serial_number_degree_tdcm" => ['required'],   
            "place_of_degree_tdcm"      => ['required'],   
        ];
    }

    public function messages()
    {
        return [
            'avatar.required'                       => 'Vui lòng chọn ảnh avatar',

            'place_of_birth'                        => 'Vui lòng chọn nơi sinh',
            'nations_name'                          => 'Vui lòng chọn quốc tịch',
            'ethnics_name'                          => 'Vui lòng chọn dân tộc',

            'type_id_tdcm.required'                 => 'Vui lòng chọn bằng tốt nghiệp',
            'year_of_degree_tdvh.required'          => 'Vui lòng nhập năm tốt nghiệp',
            'date_of_degree_tdvh.required'          => 'Vui lòng chọn ngày cấp',
            'serial_number_degree_tdvh.required'    => 'Vui lòng nhập số văn bằng',
            'place_of_degree_tdvh.required'         => 'Vui lòng nhập nơi cấp (Trường THPT/BTTH)',
            
            'type_id_tdvh.required'                 => 'Vui lòng chọn loại hình đào tạo',
            'year_of_degree_tdcm.required'          => 'Vui lòng nhập năm tốt nghiệp',
            'date_of_degree_tdcm.required'          => 'Vui lòng chọn ngày cấp',
            'serial_number_degree_tdcm.required'    => 'Vui lòng nhập số văn bằng',
            'place_of_degree_tdcm.required'         => 'Vui lòng nhập nơi cấp (Trường Đại học/Cao đẳng)',
            // Date Of Birthday.
            'date_of_birth.required'        => 'Vui lòng nhập ngày sinh',
            'date_of_birth.date_format'     => 'Ngày sinh không đúng định dạng d/m/Y',
            // CCCD
            'identification_card.required'  => 'Vui lòng nhập Căn cước công dân',
            'identification_card.size'      => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            'identification_card.regex'     => 'Căn cước công dân không đúng định dạng',
            'identification_card.unique'    => 'Căn cước công dân đã tồn tại trên hệ thống',
            // Date Of Birthday.
            'date_identification_card.required'       => 'Vui lòng nhập ngày cấp',
            'date_identification_card.date_format'    => 'Ngày sinh không đúng định dạng d/m/Y',
            'place_identification_card.required'      => 'Vui lòng nhập nơi cấp',
            'email.email'   => "Email không đúng định dạng",                             
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
