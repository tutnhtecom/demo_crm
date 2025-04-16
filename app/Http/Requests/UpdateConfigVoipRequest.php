<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateConfigVoipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'api_key'       => ['required', 'unique:config_voip,api_key,' . $this->id],
            'api_secret'    => ['required', 'unique:config_voip,api_secret,' . $this->id],
            'voip_ip'       => ['required', 'unique:config_voip,voip_ip,' . $this->id],
        ];
    }

    public function messages(){
        return [
            'api_key.required'      => "Vui lòng nhập api key của Voip", 
            'api_secret.required'   => "Vui lòng nhập api secret của Voip", 
            'voip_ip.required'      => "Vui lòng nhập ip của Voip", 
            'api_key.unique'        => "api_key đã tồn tại trên hệ thống", 
            'api_secret.unique'     => "api_secret đã tồn tại trên hệ thống", 
            'voip_ip.unique'        => "voip_ip đã tồn tại trên hệ thống" ,
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
