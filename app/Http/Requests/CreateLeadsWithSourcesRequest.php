<?php

namespace App\Http\Requests;

use App\Models\Leads;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateLeadsWithSourcesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        $rules['full_name'] = ['required','max:255', 'min:1'];
        // if(isset($this->email) && strlen($this->email)){
        //     $rules['email'] = ['required','max:255', 'email', function ($attribute, $value, $fail) {
        //         $eLeadsUnique = Leads::where('email', $value)->count();
        //         $eUserUnique = User::where('email', $value)->whereNull('deleted_at')->count();
        //         if ($eLeadsUnique > 0 || $eUserUnique > 0) {
        //             $fail('Email đã tồn tại trên hê thống');
        //         }
        //     }];
        // } 
        $rules['email'] = [
            'required',  // Đảm bảo luôn có rule 'required'
            'max:255',
            'email',
            function ($attribute, $value, $fail) {
                $emailExistsInLeads = Leads::where('email', $value)->exists();
                $emailExistsInUsers = User::where('email', $value)->whereNull('deleted_at')->exists();
        
                if ($emailExistsInLeads || $emailExistsInUsers) {
                    $fail('Email đã tồn tại trên hệ thống.');
                }
            }
        ];
        // $rules['phone'] = ['required','regex:/^(\d{10}|\d{11}|\d{12})$/', 'unique:leads,phone'];
        $rules['phone'] = [
            'required',  
            'regex:/^(\d{10}|\d{11}|\d{12})$/', // Chỉ chấp nhận số điện thoại có 10, 11 hoặc 12 chữ số
            function ($attribute, $value, $fail) {
                $phoneExists = Leads::where('phone', $value)
                            ->whereNull('deleted_at')
                            ->exists();
        
                if ($phoneExists) {
                    $fail('Số điện thoại đã tồn tại trên hệ thống.');
                }
            }
        ];
        // if(isset($this->phone) && strlen($this->phone)){
        // } 

       return $rules;
    }

    public function messages()
    {
        return [
            'full_name.required' => 'Vui lòng nhập đầy đủ Họ và tên',
            'full_name.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'full_name.max' => 'Thông tin phải có tối đa 255 ký tự',
            
            'email.required' => 'Vui lòng nhập đầy đủ Email',
            'email.min' => 'Thông tin phải có ít nhất 1 ký tự',
            'email.email' => 'Email không đúng định dạng', 

            'phone.required' => 'Vui lòng nhập đầy đủ Số điện thoại',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại', 
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
