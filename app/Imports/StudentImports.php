<?php

namespace App\Imports;

use App\Models\Contacts;
use App\Models\DegreeInformations;
use App\Models\Employees;
use App\Models\FamilyInformations;
use App\Models\Files;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Models\Marjors;
use App\Models\PriceLists;
use App\Models\ScoreAdminssions;
use App\Models\Sources;
use App\Models\Students;
use App\Models\Transactions;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImports implements ToModel, WithStartRow, WithValidation,SkipsEmptyRows
{
    use Information, General;
    public function startRow(): int
    {
        return 4;
    }
    public function model(array $row) {   
        try {    
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }               
            $leads = Leads::where('leads_code', trim($row[1]))->first();
            if(!isset($leads) || $leads == null) { 
                $email_error[] = trim($row[8]);                                       
            } else { 
                $data = [
                    "code"                  => $leads->code,
                    "leads_id"              => $leads->id,
                    "students_code"         => trim($row[1]) ?? null,
                    "full_name"             => trim($row[2]) ?? null,                        
                    "date_of_birth"         => strlen(trim($row[3])) ? Carbon::createFromFormat('d/m/Y', trim($row[3]))->format('Y-m-d') : null,
                    "phone"                 => trim($row[4]) ?? null,
                    "home_phone"            => trim($row[5]) ?? null,
                    "identification_card"   => trim($row[6]) ?? null,
                    "gender"                => Leads::FEMALE ==  trim($row[7]) ? Leads::FEMALE : (Leads::MALE ==  trim($row[7]) ? Leads::MALE : Leads::ORTHER) ?? null,
                    "email"                 => trim($row[8]) ?? null,   
                    "code"                  => Leads::where('email', trim($row[8]))->first()->code,             
                    "assignments_id"        => Employees::where('name',  'LIKE', '%'.trim($row[9]).'%')->first()->id ?? null,
                    "lst_status_id"         => LstStatus::where('name',  'LIKE', '%'.trim($row[10]).'%')->first()->id ?? null,
                    "sources_id"            => Sources::where('name',  'LIKE', '%'.trim($row[11]).'%')->first()->id ?? null,
                    "marjors_id"            => Marjors::where('name', 'LIKE', '%'.trim($row[12]).'%')->first()->id ?? null,
                    "created_by"            => Auth::user()->id ?? null,                   
                ];                                        
                $model = Students::create($data);                    
                if(isset($model->leads_id)) {                        
                    Contacts::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    FamilyInformations::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    ScoreAdminssions::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    Files::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    DegreeInformations::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    PriceLists::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                    Transactions::where('leads_id', $model->leads_id)->update([
                        "students_id" => $model->id,
                        "updated_by"  => Auth::user()->id ?? null, 
                    ]);
                }
            }   
        } catch (\Exception $e) {            
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
            '1' => ['required','max:255', 'min:8', 'unique:students,students_code'],
            '2' => ['required','max:255', 'min:8'],
            '3' => ['required', 'date_format:d/m/Y', 'before:now'],
            '4' => ['required', 'unique:students,phone', 'max:12', 'min:10'],
            '5' => ['required', 'unique:students,home_phone', 'max:12', 'min:10'],
            '6' => ['required', 'size:12', 'unique:students,identification_card', 'regex:/^(\d{09}|\d{10}|\d{11}|\d{12})$/'],
            '7' => ['required', 'regex:/^[Nam,Nữ]+$/'],
            '8' => ['required','max:255', 'min:8', 'email', 'unique:students,email'],                       
            '9' => ['required',  function ($attribute, $value, $fail) {
                $employees = Employees::where('name', $value)->count();                
                if ($employees <= 0) {
                    $fail('Tên nhân viên: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '10' => ['required',  function ($attribute, $value, $fail) {
                $status = LstStatus::where('name', $value)->count();                
                if ($status <= 0) {
                    $fail('Trạng thái: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '11' => ['required',  function ($attribute, $value, $fail) {
                $sources = Sources::where('name', $value)->count();                
                if ($sources <= 0) {
                    $fail('Nguồn tiếp cận: ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '12' => ['required',  function ($attribute, $value, $fail) {
                $marjors = Marjors::where('name', $value)->count();                
                if ($marjors <= 0) {
                    $fail('Ngành học: ' . $value .' không tồn tại trên hệ thống');
                }
            }],            
        ];
    }
    public function customValidationMessages()
    {        
        return [
            // Mã số sinh viên            
            '1.required'        => 'Vui lòng nhập đầy đủ Mã số sinh viên',
            '1.min'             => 'Độ dài tối thiểu 8 ký tự',
            '1.max'             => 'Độ dài tối đa 255 ký tự',
            '1.unique'          => 'Mã số sinh viên đã tồn tại',
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
            '4.min'             => 'Độ dài tối thiểu 10 ký tự',
            '4.max'             => 'Độ dài tối đa 12 ký tự',            
            '4.unique'          => 'Số điện thoại đã tồn tại trên hệ thống',
            // Số điện thoại nhà riêng
            '5.required'        => 'Vui lòng nhập Số điện thoại nhà riêng',
            '5.min'             => 'Độ dài tối thiểu 10 ký tự',
            '5.max'             => 'Độ dài tối đa 12 ký tự',            
            '5.unique'          => 'Số điện thoại nhà riêng đã tồn tại trên hệ thống',
            // CCCD
            '6.required'        => 'Vui lòng nhập Căn cước công dân',           
            '6.size'            => 'Độ dài Căn cước công dân phải đúng 12 ký tự',
            '6.regex'           => 'Căn cước công dân không đúng định dạng',
            '6.unique'          => 'Căn cước công dân đã tồn tại trên hệ thống',
            // Gender
            '7.required'        => 'Vui lòng chọn giới tính',
            '7.regex'           => 'Giá trị của giới tính thuộc 1 trong các giá trị [Nam, Nữ, Khác]',   
            // Email
            '8.required'        => 'Vui lòng nhập đầy đủ Email',
            '8.min'             => 'Email phải có ít nhất 8 ký tự',
            '8.max'             => 'Email phải có tối đa 255 ký tự',
            '8.email'           => 'Email không đúng định dạng',
            '8.unique'          => 'Email đã tồn tại trên hệ thống',
            // tư vấn viên
            '9.required'        => 'Vui lòng nhập đầy đủ Tư vấn viên',

            '10.required'       => 'Vui lòng nhập đầy đủ Trạng thái',
            '11.required'       => 'Vui lòng nhập đầy đủ Nguồn tiếp cận',
            '12.required'       => 'Vui lòng nhập đầy đủ Ngành học',            
        ];
    }
}
