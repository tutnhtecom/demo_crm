<?php

namespace App\Http\Requests;

use App\Models\Permissions;
use App\Models\Roles;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateRolePermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {        
        return [                        
            'roles_id' => ['nullable', function ($attribute, $value, $fail) {
                $dem = Roles::where('id', $value)->count();
                if ($dem <= 0) {
                    $fail('Vai trò không tồn tại');
                }
            }],    
            'permissions_id' => ['nullable', function ($attribute, $value, $fail) {
                $dem = Permissions::whereIn('id', $value)->count();
                if ($dem <= 0) {
                    $fail('Trong danh sách phân quyền, có quyền không tồn tại trên hệ thống');
                }
            }],        
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors(); 
        throw new HttpResponseException(response()->json([ 'code' => '422', 'data' => $errors ]));            
    }
}
