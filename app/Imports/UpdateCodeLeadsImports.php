<?php

namespace App\Imports;

use App\Models\Leads;
use App\Models\Students;
use App\Traits\General;
use App\Traits\Information;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
class UpdateCodeLeadsImports implements ToModel, WithStartRow, WithChunkReading,WithValidation, SkipsEmptyRows
{
    use Information, General;
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 500;
    }
    public function model(array $row){
        if (empty(array_filter($row))) {
            return null; // Bỏ qua dòng trống
        }
        Leads::where('email', $row[1])->update([
            "leads_code" => $row[2]
        ]);
    }
    public function rules(): array
    {           
        return [
            '1' => ['required', function ($attribute, $value, $fail) {
                $dem = Leads::where('email', $value)->count();                
                if ($dem <= 0) {
                    $fail('Email:  ' . $value .' không tồn tại trên hệ thống');
                }
            }],
            '2' => ['required'],
        ];
    }
    public function customValidationMessages()
    {        
        return [
            // Mã số sinh viên            
            '1.required'        => 'Vui lòng nhập đầy đủ Email',                  
            '2.required'        => 'Vui lòng nhập đầy đủ Mã số sinh viên',
            // '24.unique'      => 'Số điện thoại Mẹ đã tồn tại trên hệ thống',
        ];
    }
}
