<?php

namespace App\Http\Requests;

use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Traits\General;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEmailTemplateRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'file_name' => ['nullable','max:255', 'min:1', 'unique:email_templates,file_name,'.$this->id],
            'types_id'      => ['required', function ($attribute, $value, $fail) {
                $types = EmailTemplateTypes::where('id', $value)->count();
                if ($types <= 0) {
                    $fail('Loại mẫu email không tồn tại');
                }
            }], 
            'title'     => ['required','max:255', 'min:1'],
        ];
    }

    public function messages()
    {
        return [            
            'file_name.min'     => 'Thông tin phải có độ dài ít nhất 1 ký tự',
            'file_name.max'     => 'Thông tin phải có độ dài tối đa 255 ký tự',                          
            
            'types_id.required'     => 'Vui lòng chọn loại mẫu mail',

            'title.required'     => 'Vui lòng nhập tiêu đề',
            'title.min'     => 'Thông tin phải có độ dài ít nhất 1 ký tự',
            'title.max'     => 'Thông tin phải có độ dài tối đa 255 ký tự',              

            
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
