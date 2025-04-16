<?php

namespace App\Http\Requests;

use App\Models\Notifications;
use App\Models\NotificationsGroups;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class CreateNotificationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {

        $rules = [
        'title'         => ['required','max:150', 'min:1'],
        'content'       => ['required', 'min:1'],
        'obj_types'     => ['required', 'in:0,1,2,3'],
        'status'        => ['nullable', 'in:0,1'],
        ];

        if(isset($this->File)){
            $rules['File'] = ['nullable', 'mimes:csv,txt,xlsx,xls'];
        } else {
            // Kiểm tra kiểu đối tượng gửi
            // Gửi theo nhóm
            if(isset($this->obj_types) && $this->obj_types == Notifications::OBJECT_GROUPS) {
                if(!isset($this->groups_id) && empty($this->groups_id)) {
                    $rules['groups_id'] = [function ($attribute, $value, $fail) {
                        $fail('Vui lòng chọn nhóm gửi thông báo');
                    }];
                } else {
                    $groups = NotificationsGroups::where('id', $this->groups_id)->count();
                    if ($groups <= 0) {
                        $rules['groups_id'] = [function ($attribute, $value, $fail) {
                            $fail('Vui lòng chọn nhóm gửi thông báo');
                        }];
                    }
                }
            } else {
                $rules['email'] = ["required"];
            }
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'email.required' => 'Vui lòng nhập danh sách người nhận',
            'title.required' => 'Vui lòng nhập đầy đủ Tiêu đề',
            'title.min' => 'Độ dài Tiêu đề tối thiểu 1 ký tự',
            'title.max' => 'Độ dài Tiêu đề tối đa 150 ký tự',
            'content.required' => 'Vui lòng nhập đầy đủ Nội dung',
            'content.min' => 'Độ dài Nội dung tối thiểu 1 ký tự',
            'obj_types.required' => 'Vui lòng chọn đối tượng nhận: Thí sinh mới, Sinh viên, Nhân sự',
            'obj_types.in' => 'Vui lòng chọn đúng đối tượng gửi thông báo: 0: Thí sinh mới, 1: Sinh viên, 2: Nhân sự',
            'obj_types.required' => 'Vui lòng chọn đối tượng nhận: Thí sinh mới, Sinh viên, Nhân sự',
            'status.in' => 'Vui lòng chọn đúng trạng thái: 0: Nháp, 1: Đã gửi',
            'File.mimes' => 'File import không đúng định dạng: xlsx, xls, txt, csv'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));
    }
}
