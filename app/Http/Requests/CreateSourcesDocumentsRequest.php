<?php

namespace App\Http\Requests;

use App\Models\Sources;
use App\Models\SourcesDocuments;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateSourcesDocumentsRequest extends FormRequest
{
    use General;
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            "sources_id" => ['required', function ($attribute, $value, $fail) {
                $dem = Sources::where('id', $value)->count();
                if ($dem <= 0) {
                    $fail('Đơn vị liên kết không tồn tại');
                }
            }],
            "signed_document"   => ['required'],
            "code"              => ['nullable', 'unique:sources_documents,code', 'min:3'],
            "signed_content"    => ['required'],
            "signed_from_date"  => ['required'],
            "signed_to_date"    => ['required', function ($attribute, $value, $fail) {
                $status = $this->greate_than($this->signed_from_date , $value);
                if ($status) {
                    $fail('Ngày bắt đầu phải nhỏ hơn hoặc bằng ngày kết thúc');
                }
            }],
        ];
    }

    public function messages()
    {
        return [
            "code.unique"                       => "Code da ton tai",
            "sources_id.required"               => "Vui lòng chọn đơn vị liên kết",
            "signed_document.required"          => "Vui lòng nhập Văn bản ký kết",
            "signed_content.required"           => "Vui lòng nhập Nội dung ký kết",
            "signed_from_date.required"         => "Vui lòng nhập Ngày bắt đầu hợp đồng",
            "signed_to_date.required"           => "Vui lòng nhập Ngày kết thúc hợp đồng",
            "signed_to_date.after_or_equal"     => "Ngày kết thúc phải sau hoặc bằng ngày bắt đầu",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));
    }
}
