<?php

namespace App\Imports;

use App\Jobs\SourcesImportsJob;
use App\Jobs\SourcesRatesImportJobs;
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

class SourcesRatesImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
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
        try {                 
            DB::beginTransaction();
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }
            $s_condition = [
                "code"  => trim($row[0])
            ];                  
            $sources_id = $this->get_data_id_by_condition('sources', $s_condition);                 
            if(!$sources_id) {
                return [
                    "code" => 422,
                    "message" => "Không tìm thấy đối tác liên kết"
                ];
            }
            
            $s_d_condition = [
                "code"  => trim($row[1])
            ];           
            
            $sources_documents_id = $this->get_data_id_by_condition('sources_documents', $s_d_condition);            
            if(!$sources_documents_id) {
                return [
                    "code" => 422,
                    "message" => "Không tìm thấy hợp đồng trên hệ thống"
                ];
            }    
            $unit = "SV/Ngành/Khóa";
            $payment_terms_note = (isset($row[4]) ? trim($row[4]) : null) .' '. (isset($row[3]) ? trim($row[3]) : null) .' '. ($unit ?? null);                 
            $data = [
                "sources_id"            => $sources_id ?? null, //; Mã ĐVLK
                "sources_documents_id"  => $sources_documents_id ?? null,
                "expense_name"          => isset($row[2]) ? trim($row[2]) : null, // Tên khoản chi
                "payment_condition"     => isset($row[3]) ? trim($row[3]) : null, // Điểu kiện thanh toán
                "math_sign"             => isset($row[4]) ? trim($row[4]) : null,
                "payment_terms_note"    => $payment_terms_note ?? null,
                "payment_rate"          => isset($row[5]) ? trim($row[5]) : 0,                
                "payment_manager_rate"  => isset($row[6]) ? trim($row[6]) : null,                
                "payment_manager_price" => isset($row[7]) ? trim($row[7]) : null,
                "payment_note"          => isset($row[8]) ? trim($row[8]) : null,
                "created_at"            => Carbon::now(),
                "created_by"            => Auth::user()->id ?? 1,
            ];                             
            SourcesRatesImportJobs::dispatch($data);            
            DB::commit();
        } catch (\Exception $e) {
            
            DB::rollBack();
            Log::error("Thông báo lỗi: " . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }

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
