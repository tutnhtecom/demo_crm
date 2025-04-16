<?php

namespace App\Http\Requests;

use App\Models\Employees;
use App\Models\Tasks;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTasksRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            "name"          => ['required','max:155', 'min:1'],
            "employees_id"  => ['required', function ($attribute, $value, $fail) {
                $employees = Employees::where('id',$value)->count();
                if ($employees <= 0) {
                    $fail('Nhân viên không tồn tại trên hệ thống');
                }
            }],
            "from_date"     => ['required','date_format:d/m/Y',  ],
            "to_date"       => ['required','date_format:d/m/Y', 'after_or_equal:from_date' ],
            "priority"      => ['required','numeric' , function ($attribute, $value, $fail) {
                if (!in_array($value, Tasks::PRIORITY_IN)) {
                    $fail('Mức độ ưu tiên phải năm chỉ được chọn: 0, 1, 2');
                }
            }],

        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Vui lòng nhập đầy đủ thông tin',
            'name.min'                  => 'Thông tin phải có ít nhất 1 ký tự',
            'name.max'                  => 'Thông tin phải có tối đa 255 ký tự',

            'employees_id.required'     => 'Vui lòng nhập chọn nhân viên',

            'from_date.required'        => 'Vui lòng nhập ngày bắt đầu',
            'from_date.date_format'     => 'Ngày bắt đầu không đúng định dạng d/m/Y',
            'from_date.after_or_equal'  => 'Ngày bắt đầu phải lớn hơn hoặc bằng ngày hiện tại',

            'to_date.required'          => 'Vui lòng nhập ngày kết thúc',
            'to_date.date_format'       => 'Ngày kết thúc không đúng định dạng d/m/Y',
            'to_date.after_or_equal'    => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu',

            'priority.required'         => 'Vui lòng chọn mức độ ưu tiên',
            'priority.numeric'          => 'Mức độ ưu tiên không phải là dạng số',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));
    }
}
