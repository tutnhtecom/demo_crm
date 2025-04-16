<?php

namespace App\Imports;

use App\Jobs\ReportSourcesImportsJobs;
use App\Jobs\SourcesImportsJob;
use App\Models\ReportPriceListsBySources;
use App\Models\Semesters;
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
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\HeadingRowImport;
use Maatwebsite\Excel\Imports\HeadingRowExtractor;

// WithValidation
class ReportSourcesImports implements ToModel, WithStartRow, WithChunkReading, SkipsEmptyRows
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
    private function get_id_by_condition($table, $condition) {      
        $id = $this->get_data_id_by_condition($table, $condition);           
        return $id;
    }
    private function get_data_semesters($academic_terms_id) {     
        $data = Semesters::where('academic_terms_id', $academic_terms_id)->get();                
        return $data;
    }
    public function model(array $row){       
        try {                        
            DB::beginTransaction();
            if (empty(array_filter($row))) {
                return null; // Bỏ qua dòng trống
            }
            // $sources_id          = isset($row[0]) ? $this->get_id_by_condition('sources', ["name" => trim($row[0])]) : null;
            $sources_id          = isset($row[0]) ? $this->get_id_by_condition('sources', ["code" => trim($row[0])]) : null;            
            $students_id         = isset($row[1]) ? $this->get_id_by_condition('students', ["full_name" => trim($row[1])]) : null;
            $academic_terms_id   = isset($row[3]) ? $this->get_id_by_condition('academic_terms', ["name" => trim($row[3])]) : null;
            $marjors_id          = isset($row[4]) ? $this->get_id_by_condition('marjors', ["name" => trim($row[4])]) : null;
            $semesters           = $this->get_data_semesters ($academic_terms_id);
            $semesters_name      = $semesters->pluck('name')->toArray();
            $data_semesters_name = [];
            foreach ($semesters_name as $key => $name) {
                if($name == "Học kỳ 1" &&  isset($row[5])) $data_semesters_name [$name] = trim($row[5]);
                if($name == "Học kỳ 2" &&  isset($row[6])) $data_semesters_name [$name] = trim($row[6]);
                if($name == "Học kỳ 3" &&  isset($row[7])) $data_semesters_name [$name] = trim($row[7]);
            }
            $price_lists                = json_encode($data_semesters_name);
            $data = [
                "sources_id"            => isset($row[0]) ? $sources_id  : null, // Ma DVLK
                "sources_name"          => isset($row[0]) ? trim($row[1]) : null, // Ten DVLK
                "students_id"           => isset($row[1]) ? $students_id  : null, // ID sinh vien
                "students_name"         => isset($row[1]) ? trim($row[1]) : null, // Ten sinh vien
                "students_code"         => isset($row[2]) ? trim($row[2]) : null, // Ma Sinh vien
                "academic_term_id"      => isset($row[3]) ? $academic_terms_id  : null, // ID sinh vien
                "acedemic_term_name"    => isset($row[3]) ? trim($row[3]) : null, // Ten sinh vien
                "marjors_id"            => isset($row[4]) ? $marjors_id  : null, // ID nganh
                "marjors_name"          => isset($row[4]) ? trim($row[4]) : null, // Ten nganh
                "price_lists"           => $price_lists   ?? null, // hoc phi
                "created_at"            => Carbon::now(),
                "created_by"            => Auth::user()->id ?? 1,
            ];
            ReportPriceListsBySources::create($data);     
            // ReportSourcesImportsJobs::dispatch($data);
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
            "1.required"        => "Vui lòng nhập phân loại",                       
            "2.required"        => "Vui lòng nhập Tên ĐVLK",
            "2.unique"          => "Tên ĐVLK đã tồn tại trên hệ thống",             
            "3.unique"          => "Mã ĐVLK đã tồn tại trên hệ thống",  
            "10.after_or_equal" => "Thời gian kết thúc hợp đồn lớn hơn hoặc bằng"
        ];
    }
}
