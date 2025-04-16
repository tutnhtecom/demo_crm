<?php

namespace App\Imports;

use App\Jobs\AcademicTermsImportJobs;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class AcademicTermsImports implements ToCollection, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
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
        foreach ($rows as $key => $row){             
             $data[]   = [                                
                 "name"              => trim($row[1]),                    
                 "from_year"         => trim($row[2]),
                 "to_year"           => trim($row[3]),
                 "note"              => trim($row[4])           
             ];   
       
         }                               
         AcademicTermsImportJobs::dispatch($data);
     }
     public function rules(): array
     {                 
         return [
             '1' => ['required', 'max:255', 'min:1'],
             '2' => ['required', 'unique:api_lists,request_url', 'min:1'],
             '3' => ['required', 'min:1'],  
             '4' => ['required'], 
             
         ];
     }
     public function customValidationMessages()
     {        
         return [
             '1.required'         => 'Vui lòng nhập tên niên khóa',
             '1.min'              => 'Độ dài tối thiểu 1 ký tự',
             '1.max'              => 'Độ dài tối đa 255 ký tự',            
 
             '2.required'         => 'Vui lòng nhập Năm bắt đầu',
             '2.numeric'          => 'Năm bắt đầu phải dạng số',                  
 
             '2.required'         => 'Vui lòng nhập Năm kết thúc',
             '2.numeric'          => 'Năm kết thúc phải dạng số',                  
 
             '4.required'         => 'Vui lòng nhập Mô tả',            
         ];
     }
}
