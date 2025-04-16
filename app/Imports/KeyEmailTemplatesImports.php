<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Jobs\AcademicTermsImportJobs;
use App\Models\EmailTemplateKey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
// WithValidation
class KeyEmailTemplatesImports implements ToCollection, WithStartRow, WithChunkReading, SkipsEmptyRows
{
    public function startRow(): int
    {
        return 2;
    }
    public function chunkSize(): int
    {
        return 50;
    }
    protected $email_template_types_id;
    public function __construct($email_template_types_id){              
        $this->email_template_types_id = $email_template_types_id;
    }
    
    public function collection(Collection $collection)
    {  
        $data = [] ;
        foreach ($collection as $key => $row){             
            $data[]   = [                                
                "display_name"      => trim($row[1]),                    
                "default_key"       => trim($row[2]),
                "customs_key"       => trim($row[3]),
                "created_at"        => Carbon::now(),
                "created_by"        => Auth::user()->id ?? 1,
                "email_template_types_id" => $this->email_template_types_id
            ];
        }        
        EmailTemplateKey::insert($data);
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
