<?php

namespace App\Http\Requests;

use App\Models\LineVoip;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateVoip24hRequest extends FormRequest
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
            'line_id' => ['required', 'unique:line_voip,line_id,' . $this->id],
            'line_password' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'line_id.required' => 'Vui lòng nhập mã máy nhánh',
            'line_id.unique' => 'ID máy nhánh đã tồn tại',
            'line_password.required' => 'Vui lòng nhập mật khẩu máy nhánh',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
