<?php

namespace App\Imports;

use App\Jobs\ApiListImportJobs;
use App\Jobs\EmployeesImportJobs;
use App\Jobs\UsersImportJobs;
use App\Models\Employees;
use App\Models\Roles;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ApiListImports implements ToCollection, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    // 
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 50;
    }
    public function collection(Collection $collection)
    {   
        $data = [];
        $rows = $collection->filter(function ($row) {
            return $row->filter()->isNotEmpty(); // Lọc bỏ các dòng trống
        });
        foreach ($rows as $row) 
        {  
            $data[]   = [                                
                "name"              => trim($row[1]),                    
                "request_url"       => trim($row[2]),
                "method_name"       => trim($row[3]),
                "body"              => json_encode(trim($row[4])),
                "controller_name"   => trim($row[5]) ?? null,
                "action_name"       => trim($row[6]) ?? null,
                "auth_type"         => trim($row[7]) ?? null,
                "created_at"        => Carbon::now(),
                "created_by"        => Auth::user()->id
            ];   
      
        }                
        ApiListImportJobs::dispatch($data);
    }
    public function rules(): array
    {           
        return [
            '1' => ['required', 'max:255', 'min:8'],
            '2' => ['required', 'unique:api_lists,request_url', 'min:1'],
            '3' => ['required', 'min:1'],  
            '4' => ['required'], 
            
        ];
    }
    public function customValidationMessages()
    {        
        return [
            '1.required'         => 'Vui lòng nhập tên của API',
            '1.min'              => 'Độ dài tối thiểu 8 ký tự',
            '1.max'              => 'Độ dài tối đa 255 ký tự',            

            '2.required'         => 'Vui lòng nhập Request URL',
            '2.min'              => 'Độ dài tối thiểu 1 ký tự',       
            '2.unique'           => 'Request URL đã tồn tại trên hệ thống',     

            '3.required'         => 'Vui lòng nhập Phương thức',            
            '3.min'              => 'Độ dài tối thiểu 1 ký tự', 

            '4.required'         => 'Vui lòng nhập đầy đủ Môn xét tuyển',            
            '4.min'              => 'Môn xét tuyển phải có tối đa 255 ký tự',    
            
        ];
    }
}
