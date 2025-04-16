<?php

namespace App\Imports;

use App\Jobs\ImportSourcePriceListJobs;
use App\Models\Semesters;
use App\Models\Students;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SourcesPriceListsImports implements ToModel,  WithStartRow, WithChunkReading, WithHeadingRow, WithValidation, SkipsEmptyRows
{
    use General;
    // use Information, General;
    public function startRow(): int
    {
        return 3;
    }
    public function chunkSize(): int
    {
        return 500;
    }
    protected $semesters_id;
    public function __construct($semesters_id)
    {
        $this->semesters_id = $semesters_id;                
    }
    private function get_data_students($row){
        $model = Students::with(['sources', 'marjors', 'academic_terms'])->where('students_code', $row[2])->first();                
        return $model ?? null;
    }
    private function get_data_semesters($semesters_id){
        $model = Semesters::with(['academic_terms'])->where('id',  $semesters_id )->first();
        return $model ?? null;
    }
    public function model(array $row)
    {   
        if (empty(array_filter($row))) {
            return null; // Bỏ qua dòng trống
        }
        $students = $this->get_data_students($row);        
        if(!isset($students["id"])) {
            return [
                "code"      => 422, 
                "message"   => "Sinh viên không tồn tại"
            ];
        }
        
        $semesters = $this->get_data_semesters($this->semesters_id);     
        $data = [
            "sources_id"            => $students["sources"]["id"] ?? null,
            "sources_name"          => $students["sources"]["name"] ?? null,
            "students_id"           => $students["id"],
            "students_name"         => trim($row[1]) ?? "",
            "students_code"         => trim($row[2]) ?? "",
            "students_phone"        => $students["phone"] ?? "",
            "students_email"        => $students["email"] ?? "",            
            "marjors_id"            => $students["marjors"]["id"] ?? null,
            "marjors_name"          => $students["marjors"]["name"] ?? null,
            "sources_code"          => $students["sources"]["code"] ?? null,
            "acedemic_term_id"      => $semesters["academic_terms"]["id"] ?? null,
            "acedemic_term_name"    => $semesters["academic_terms"]["name"] ?? null,
            "semesters_year"        => $semesters["from_year"] ?? null,
            "semesters_id"          => $semesters["id"] ?? null,
            "semesters_name"        => $semesters["name"] ?? null,
            "tran_status"           => trim($row[3]),
            "price"                 => trim($row[4]),
            "old_debt"              => trim($row[5]),
            "note"                  => trim($row[6]),
            "created_by"            => Auth::user()->id,
            "created_at"            => Carbon::now()
        ];        
        ImportSourcePriceListJobs::dispatch($data);        
    }
    public function rules(): array
    {     
        return [
            "1"  => ["required", function ($attribute, $value, $fail) {
                
                $sources = Students::where('full_name', $value)->count();                
                if ($sources <= 0) {
                    $fail('Tên sinh viên không tồn tại trên hệ thống ');
                }
            }],
            "2"  => ["required", function ($attribute, $value, $fail) {
                $sources = Students::where('students_code', $value)->count();                                
                if ($sources <= 0) {
                    $fail('MSSV không tồn tại trên hệ thống');
                }
            }],           
        ];
    }
    public function customValidationMessages()
    {
        return [
            "1.required"        => "Vui lòng nhập Họ và tên",
            "2.required"        => "Vui lòng nhập MSSV "
        ];
    }
}
