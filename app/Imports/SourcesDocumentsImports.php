<?php

namespace App\Imports;

use App\Jobs\SourcesDocumentsImportJobs;
use App\Jobs\SourcesImportsJob;
use App\Jobs\SourcesRatesImportJobs;
use App\Models\Sources;
use App\Models\SourcesDocuments;
use App\Models\SourcesRates;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class SourcesDocumentsImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
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
    public function model(array $row)
    {                         
        $condition = [
            "code"  => trim($row[1])
        ];       
        $max_id = SourcesDocuments::max('id');   
        if(!$max_id) {
            $max_id = "01";
        }                
        $code =   $this->get_code_from_name(trim($row[2])) . ($max_id);
        $sources_id = $this->get_data_id_by_condition('sources', $condition); 
        $data = [
            "sources_id"            => $sources_id, //; Mã ĐVLK                
            "code"                  => $code ?? null,
            "signed_document"       => isset($row[2]) ? trim($row[2]) : null,
            "signed_content"        => isset($row[3]) ? trim($row[3]) : null,
            "signed_from_date"      => isset($row[4]) ? Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d') : null,
            "signed_to_date"        => isset($row[5]) ? Carbon::createFromFormat('d/m/Y', $row[5])->format('Y-m-d') : null,                 
            "created_at"            => Carbon::now()->format('Y-m-d') ,
            "created_by"            => Auth::user()->id ?? 1,
        ];    
        // SourcesDocuments::create($data);                   
        SourcesDocumentsImportJobs::dispatch($data);   
    }
   
    public function rules(): array
    {     
        return [
            "1"  => ["required"],
            "2"  => ["required", "unique:sources,name"],
            "3"  => ["nullable", "unique:sources,code"],           
            "10" => ["nullable", "after_or_equal:from_date"],           
        ];
    }
    public function customValidationMessages()
    {
        return [
            "1.required"        => "Vui lòng nhập mã ĐVLK",                       
            "2.required"        => "Vui lòng nhập Tên ĐVLK",
            "2.unique"          => "Tên ĐVLK đã tồn tại trên hệ thống",             
            "3.unique"          => "Mã ĐVLK đã tồn tại trên hệ thống",  
            "10.after_or_equal" => "Thời gian kết thúc hợp đồn lớn hơn hoặc bằng"
        ];
    }
}
