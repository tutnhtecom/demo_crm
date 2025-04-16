<?php

namespace App\Http\Requests;

use App\Models\LineVoip;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateVoip24hRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'line_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (LineVoip::where('line_id', $value)->whereNull('deleted_at')->exists()) {
                        $fail('ID máy nhánh đã tồn tại.');
                    }
                },
            ],
            'line_password' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'line_id.required' => 'Vui lòng nhập mã máy nhánh',
            'line_password.required' => 'Vui lòng nhập mật khẩu máy nhánh',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
