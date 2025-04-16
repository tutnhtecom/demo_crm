<?php

namespace App\Imports;

use App\Jobs\SourcesImportsJob;
use App\Models\Sources;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use DateTime;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// WithValidation
class SourcesImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    use Information, General;
    public function startRow(): int
    {
        return 3;
    }
    public function chunkSize(): int
    {
        return 500;
    }

    private function get_manager_information($row){        
        $manager[] = [
            "name"      => trim($row[4]),
            "positions" => trim($row[5]),
            "email"     => trim($row[6]),
            "phone"     => trim($row[7]),
        ];
        return $manager;
    }
    private function get_employees_information($row){
        if(isset($row[8]) && strlen($row[8]) > 0) {
            $employees[] =
            [
                "name"      => trim($row[8]),
                "positions" => trim($row[9]),
                "email"     => trim($row[10]),
                "phone"     => trim($row[11]),
            ];
            
        }
        if(isset($row[12]) && strlen($row[12]) > 0) {
            $employees[] =
            [
                "name"      => trim($row[12]),
                "positions" => trim($row[13]),
                "email"     => trim($row[14]),
                "phone"     => trim($row[15]),
            ];
            
        }
        return $employees;
    }
    public function model(array $row){       
        try {            
            DB::beginTransaction();           
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }            
            $code       = $this->get_code(trim($row[3])); 
            $manager    = $this->get_manager_information($row);            
            $employees  = $this->get_employees_information($row);
            $data       = [
                "sources_types"             => trim($row[1]) ?? null, // Phân loại
                "name"                      => trim($row[2]) ?? null, // Tên đơn vị liên kết
                "code"                      => $code, // Mã ĐVLK
                "location_name"             => trim($row[3]), // Địa phương
                "sources_manager_name"      => $manager != null ? json_encode($manager) : null,  // Tên lãnh đạo
                "sources_employees_name"    => $employees != null ? json_encode($employees) : null,  // Tên lãnh đạo                
                "created_at"                => Carbon::now(),
                "created_by"                => Auth::user()->id ?? 1,
            ];       
            Sources::create($data);       
            // SourcesImportsJob::dispatch($data);
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
            "2"  => ["required",  function ($attribute, $value, $fail) {
                $dem = Sources::where('name', $value)->count();
                if($dem > 0) {
                    $fail('Đơn vị liên kết đã tồn tại');
                }
            }],
            "3"  => ["required"],
            "10" => ["nullable", "after_or_equal:from_date"],           
        ];
    }
    public function customValidationMessages()
    {
        return [
            "1.required"        => "Vui lòng nhập phân loại",                       
            "2.required"        => "Vui lòng nhập Tên ĐVLK",
            "2.unique"          => "Tên ĐVLK đã tồn tại trên hệ thống",             
            "3.required"        => "Vui lòng nhập Địa phương",  
            "10.after_or_equal" => "Thời gian kết thúc hợp đồn lớn hơn hoặc bằng"
        ];
    }
}
