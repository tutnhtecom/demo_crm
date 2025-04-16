<?php

namespace App\Imports;

use App\Jobs\CreateKpisJobs;
use App\Jobs\CreateUserJobs;
use App\Jobs\EmployeesImportJobs;
use App\Jobs\SendMailJobs;
use App\Models\Employees;
use App\Models\Kpis;
use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\User;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use App\Models\UserRolePermissions;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// WithValidation
class EmployeesImport implements ToModel, WithStartRow, WithValidation, WithChunkReading, SkipsEmptyRows
{
    use Information, General;
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 400;
    }
    public function model(array $row)
    {        
        try {
            DB::beginTransaction();
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }
            $password = trim($row[7]) ?? Str::random(16);
            $roles = Roles::where('name', trim($row[6]))->first();
            $maxId = Employees::max('id') ? "NV00000" . Employees::max('id') + 1 : "NV00000" . rand(100000, 999999);
            // Data thêm mới cho nhân viên
            $data = [
                "code"          =>  $maxId,
                "name"          => trim($row[2]) ?? null,
                "date_of_birth" => strlen(trim($row[3])) ? Carbon::createFromFormat('d/m/Y', trim($row[3]))->format('Y-m-d') : null,
                "phone"         => trim($row[4]) ?? null,
                "email"         => trim($row[5]) ?? null,
                "roles_id"      => $roles->id ?? 3,
                "status"        => Employees::ACTIVE ?? null,
                "created_by"    => Auth::user()->id ?? null,
            ];                       
            $model = Employees::create($data);
            // Dữ liệu thêm mới cho user
            $data_user = [
                "email"         => trim($row[5]),
                "password"      => Hash::make(trim($password)),
                "status"        => User::ACTIVE,
                "types"          => User::TYPE_EMPLOYEES,
                "created_by"    => Auth::user()->id ?? null,
            ];
           
            // Lưu dữ liệu
            $user = User::create($data_user);
            $users_id = $user->id;
            // CreateUserJobs::dispatch($data_user);            
            if(isset($model->id)){
                 // Data users
                $data_kpis = [
                    "employees_id" =>  $model->id,
                    "price"         =>  0,
                    "quantity"      =>  0,
                    "from_date"     =>  Carbon::now()->startOfMonth()->format('Y-m-d'),
                    "to_date"       =>  Carbon::now()->endOfMonth()->format('Y-m-d'),
                    "created_by"    =>  Auth::user()->id ?? NULL,
                    "created_at"    =>  Carbon::now()
                ];                     
                CreateKpisJobs::dispatch($data_kpis);
                $data_sendmail = [
                    "title"         => "Thông tin đăng ký hồ sơ",
                    'subject'       => "Thông tin đăng ký hồ sơ",
                    "full_name"     => trim($row[2]) ?? null,
                    "date_of_birth" => strlen(trim($row[3])) ? Carbon::createFromFormat('d/m/Y', trim($row[3]))->format('d/m/Y') : null,
                    "phone"         => trim($row[4]) ?? null,
                    "password"      => isset($password) ?  trim($password) : Str::random(16),
                    'to'            => trim($row[5]) ?? null,
                    "email"         => trim($row[5]) ?? null,
                    "created_by"    => Auth::user()->id ?? null,
                ];                
                SendMailJobs::dispatch($data_sendmail,'includes.employee_mail');                
                // $this->set_users_roles_permission($roles->id, $model, $users_id);                
            }
            // Them quyen khi import
            DB::commit();
            return $model;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());            
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }

    }
   
    public function rules(): array
    {        
        return [
            '1' => ['nullable', 'max:155', 'min:1'],
            '2' => ['required', 'max:155', 'min:1'],
            '3' => ['required', 'before:now'],
            '4' => ['required', 'unique:employees,phone', 'max:12', 'min:10'],
            '5' => ['nullable', 'max:255', 'min:1', 'regex:/^[a-zA-Z0-9.]+@[a-zA-Z0-9.]+\.[a-zA-Z]{2,}$/', function ($attribute, $value, $fail) {
                $users = User::where('email', $value)->count();
                $employees = Employees::where('email', $value)->count();                
                if ($users > 0 || $employees > 0) {
                    $fail('Email: ' . $value .' đã tồn tại');
                }
            }],
            '6' => ['required',function ($attribute, $value, $fail) {
                $model= Roles::where('name', $value)->first();
                if (!isset($model->id)) {                    
                    $fail('Vai trò không tồn tại trên hệ thống');
                }
                $permissions = RolePermissions::where('roles_id', $model->id)->get()->pluck('permissions_id')->toArray();                 
                if(count($permissions) <= 0) {
                    $fail('Vai trò chưa được gán quyền');
                }
            }]
        ];
    }
    public function customValidationMessages()
    {
        return [
            // Mã nhân viên
            '1.required'        => 'Vui lòng nhập đầy đủ Mã nhân viên',
            '1.min'             => 'Độ dài Mã nhân viên tối thiểu 8 ký tự',
            '1.max'             => 'Độ dài Mã nhân viên tối đa 155 ký tự',
            '1.unique'          => 'Mã nhân viên đã tồn tại',
            // Họ và tên
            '2.required'        => 'Vui lòng nhập đầy đủ Họ và tên',
            '2.min'             => 'Độ dài tối thiểu 8 ký tự',
            '2.max'             => 'Độ dài tối đa 255 ký tự',
            // Ngày sinh
            '3.required'        => 'Vui lòng nhập ngày sinh',
            '3.date_format'     => 'Ngày sinh không đúng định dạng d/m/Y',
            '3.before'          => 'Ngày sinh phải nhỏ hơn ngày hiện tại',
            // Số điện thoại
            '4.required'        => 'Vui lòng nhập số điện thoại',
            '4.min'             => 'Độ dài số điện thoại tối thiểu 10 ký tự',
            '4.max'             => 'Độ dài số điện thoại tối đa 12 ký tự',
            '4.unique'          => 'Số điện thoại đã tồn tại trên hệ thống',
            // Số điện thoại nhà riêng
            '5.required'        => 'Vui lòng nhập Email',
            '5.min'             => 'Độ dài Email tối thiểu 8 ký tự',
            '5.max'             => 'Độ dài Email tối đa 255 ký tự',
            '5.unique'          => 'Email đã tồn tại trên hệ thống',
            '5.email'           => 'Email không đúng định dạng',
            // CCCD
            '6.required'        => 'Vui lòng nhập vai trò',
            // Gender

        ];
    }
}