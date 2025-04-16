<?php

namespace App\Http\Requests;

use App\Models\Leads;
use App\Models\Transactions;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvertStudentRequest extends FormRequest
{
     /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'ids' => ['required', function ($attribute, $value, $fail) {
                $is_students = Leads::whereIn('id', $value)->where('active_student', Leads::ACTIVE_STUDENTS)->count();
                if ($is_students > 0) {
                    $fail('Sinh viên tiềm này đã trở thành sinh viên chính thức');
                }
                $arr_unpaid = [];
                foreach($value as $k=>$item){
                    $has_transaction = Transactions::where('leads_id', $item)
                    ->where('tran_status_id', Transactions::TRANS_COMPLETE)->count();
                    if($has_transaction == 0){
                        $arr_unpaid[] = $item;
                    }
                }
                if (count($arr_unpaid)) {
                    $fail('Các sinh viên chưa hoàn thành học phí: #'.implode(',#', $arr_unpaid));
                }
            }]
        ];
    }

    public function messages()
    {
        return [
            'ids.required' => 'Vui lòng chọn danh sách sinh viên tiềm năng',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'message' => $errors  ]));
    }
}
