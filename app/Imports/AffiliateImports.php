<?php

namespace App\Imports;

use App\Models\DVLKStudents;
use App\Models\DVLKTransactions;
use App\Models\Marjors;
use App\Models\Sources;
use App\Traits\General;
use App\Traits\Information;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

// WithValidation
class AffiliateImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows{
    use Information, General;
    protected $semesters_id;    
    protected $processedRows;
    public function __construct($semesters_id)
    {
        $this->semesters_id = $semesters_id;                
    }
    public function startRow(): int
    {
        return 3;
    }
    public function chunkSize(): int
    {
        return 500;
    }
    
    public function model(array $row){ 
        if (empty(array_filter($row))) {
            return null; // Bỏ qua dòng trống
        }
        $students_name      = (isset($row[0]) ? trim($row[0]) : "") . " " . (isset($row[1]) ? trim($row[1]) : '');
        $students_status    = (isset($row[2]) ? trim($row[2]) : "");   
        $students_academy   = (isset($row[3]) ? trim($row[3]) : "");   
        $students_majors    = (isset($row[4]) ? trim($row[4]) : "");   
        $students_code      = (isset($row[5]) ? trim($row[5]) : "");
        $students_sources   = (isset($row[6]) ? trim($row[6]) : "");
        $students_price     = (isset($row[7]) ? trim($row[7]) : 0);
        $students_debt      = (isset($row[8]) ? trim($row[8]) : 0);
        // $condition       = ["full_name" => $students_sources];        
        $students_sources_id        = $this->get_data_by_output("sources",["name" => $students_sources], "id");        
        // Kiểm tra sinh viên tồn tại hay chưa
        $students = DVLKStudents::where('students_code', $students_code)->first();   
        $students_id = null;
        if(!isset($students->id)) {
            $data_students = [
                "students_name"         => $students_name,
                "students_code"         => $students_code,
                "students_status"       => $students_status,
                "students_academy"      => $students_academy,
                "students_majors"       => $students_majors,
                "students_sources"      => $students_sources,
                "students_sources_id"   => $students_sources_id,
            ];                        
            $model = DVLKStudents::create($data_students);   
            $students_id = $model->id;
        } else {
            $students_id = $students->id;    
        }

        $data_transactions = null;
        $data_transactions = [
            "students_id"   => $students_id,
            "semesters_id"  => $this->semesters_id,
            "tran_academy"  => $students_academy,
            "tran_price"    => $students_price,
            "tran_debt"     => $students_debt,
        ];
        DVLKTransactions::create($data_transactions);
    }
    
    public function rules(): array
    {   
        $data_rows          = $this->processedRows;
        return [
            '0'  => ['required'],
            '1'  => ['required'],
            '3'  => ['required'],
            '4'  => ['required', function ($attribute, $value, $fail) {    
                $dem = Marjors::where('name', $value)->count();                
                if ($dem <= 0) {
                    $fail('Ngành: ' . $value .' không tồn tại');
                }
            }],
            '5'  => ['required', function ($attribute, $value, $fail) use($data_rows) {    
                // ->where('students_sources_id', $data_rows['students_sources_id'])
                $model = DVLKStudents::where('id',$data_rows['students_id'])->first();                        
                if(!isset($model->id)) {
                     $fail('Mã số sinh viên: ' . $value .' không tồn tại');
                } else {
                     if(isset($model->students_sources_id) && $model->students_sources_id != $data_rows['students_sources_id'] ) {
                        $fail('ĐVLK ' . $data_rows['students_sources'] . ' không có sinh viên: ' . $data_rows['students_name']);       
                     }
                }                 
                $count = DVLKTransactions::where('students_id', $data_rows['students_id'])->where('semesters_id', $this->semesters_id)->count();
                if($count > 0) {
                    $fail ('Học kỳ này đã đóng học phí! Vui lòng chọn học kỳ khác');
                }
            }],
            '6'  => ['required' , function ($attribute, $value, $fail) {               
                $dem = Sources::where('name', $value)->count();
                if ($dem <= 0) {
                    $fail('Đơn vị liên kết: ' . $value .' không tồn tại');
                }
            }],
        ];
    }
    public function customValidationMessages(){
        return [
            "0.required"    => "Vui lòng nhập Họ và tên đệm",
            "1.required"    => "Vui lòng nhập Tên",
            "3.required"    => "Vui lòng nhập Khóa học",
            "4.required"    => "Vui lòng nhập Ngành học",            
            "5.required"    => "Vui lòng nhập Mã số sinh viên",
            "6.required"    => "Vui lòng nhập Đơn vị liên kết",
        ];
    }
    public function getProcessedRows()
    {   
        return $this->processedRows;
    }
    private function get_data_output($table, $condition, $output){
        $model = DB::table($table)->whereNull('deleted_at')
                 ->where($condition)
                 ->first();
        return $model->id ?? null;
    }
    public function prepareForValidation(array $row): array
    {
        // Chuẩn hóa email thành chữ thường                      
        $data["students_name"] = $row[0] . $row[1];
        $data["students_code"] = $row[5];
        $data["students_id"] = $this->get_data_output('dvlk_students', ["students_code" => $row[5]], "id");
        $data["students_sources"] = $row[6];        
        $data["students_sources_id"] = $this->get_data_output('sources', ["name" => $row[6]], "id");
        $this->processedRows = $data;        
        return $row;
    }
}
