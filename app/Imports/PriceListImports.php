<?php

namespace App\Imports;

use App\Jobs\CreatePriceListJobs;
use App\Jobs\SendMailJobs;
use App\Models\AcademicTerms;
use App\Models\AcademyList;
use App\Models\DVLKSemesters;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Leads;
use App\Models\PriceLists;
use App\Models\Semesters;
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

class PriceListImports implements ToModel, WithStartRow, WithChunkReading, WithValidation, SkipsEmptyRows
{
    use Information, General;
    protected $processedRows;
    protected $auto_send_mail;
    public function __construct($auto_send_mail)
    {     
        $this->auto_send_mail = $auto_send_mail;
    }
    public function startRow(): int
    {
        return 3;
    }
    public function chunkSize(): int
    {
        return 400;
    }  
    private function get_data_semesters_id($academic_terms_id, $row){             
        $from_day   = isset($row[5]) && trim($row[5]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[5]))->format('d') : null;
        $from_month = isset($row[5]) && trim($row[5]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[5]))->format('m') : null;
        $from_year  = isset($row[5]) && trim($row[5]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[5]))->format('Y') : null;
        $to_day     = isset($row[6]) && trim($row[6]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[6]))->format('d') : null;
        $to_month   = isset($row[6]) && trim($row[6]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[6]))->format('m') : null;
        $to_year    = isset($row[6]) && trim($row[6]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[6]))->format('Y') : null;        
        $model = Semesters::where('academic_terms_id', $academic_terms_id)
                ->where('name', trim($row[3]))
                ->where('from_day', $from_day)
                ->where('from_month', $from_month)
                ->where('from_year', $from_year)
                ->where('to_day', $to_day)
                ->where('to_month', $to_month)
                ->where('to_year', $to_year)
                ->first();
        return $model->id ?? null;
    }
    private function get_data_max_id($row) {
        $total_length       = 6;        
        $max_id             = PriceLists::max('id') ? PriceLists::max('id') : rand(100000, 999999);
        $len_max_id         = strlen($max_id);
        $str_code           = null;  
        $code               = null;
        for ($i = $len_max_id; $i <= $total_length; $i++) { 
            $str_code .= '0';
        }
        $code = "HP" . $str_code . $max_id;
        return $code;        
    }
    private function get_status_price_list($row){
        $status  = null;
        if(trim($row[8]) == PriceLists::STATUS_NOT_PAID_TEXT){
            $status  = PriceLists::STATUS_NOT_PAID;
        }
        if(trim($row[8]) == PriceLists::STATUS_PAID_TEXT){
            $status  = PriceLists::STATUS_PAID;
        }
        return $status;
    }
    private function get_data_leads($row) {
        $leads_condition    = ["leads_code" => trim($row[1])];        
        $leads              = $this->get_data_by_fields("leads", $leads_condition);      
        if(isset($leads->id))
        $data = [
            "id"                 => $leads->id,
            "email"              => $leads->email,
            "full_name"          => $leads->full_name,
            "leads_code"         => $leads->leads_code,
            "phone"              => $leads->phone,
        ];        
        return $data;
    }
    private function get_data_studens($row) {
        $students_code      = ["students_code" => trim($row[1])];                
        $students       = $this->get_data_id_by_condition("students", $students_code);
        $data = null;
        if(isset($students->id))
        $data = [
            "id"                 => $students->id,
            "email"              => $students->email,
            "full_name"          => $students->full_name,
            "leads_code"         => $students->students_code,
        ];                
        return $data;
    }
    private function get_file_name() {
        $types_id  = EmailTemplateTypes::TYPE_PRICE_LISTS;     
        $file_name = $this->get_data_file_name_by_types($types_id);        
        return $file_name;
    }
    public function model(array $row){   
        if (empty(array_filter($row))) {
            return null; // Bỏ qua dòng trống
        }
        $code               = isset($row[0]) && strlen($row[0]) ?  trim($row[0]) :$this->get_data_max_id($row);       
        $leads              = $this->get_data_leads($row);                
        $students           = $this->get_data_studens($row);                           
        $semesters          = $this->get_data_semesters($row[4])->first();
        $title              = trim($row[2]) .'/'. trim($row[3]) . ' ' . $semesters["semesters_name"];        
        $price              = isset($row[4]) ? trim($row[5]) : 0;
        $status             = $this->get_status_price_list($row);        
        $from_date          = isset($row[6]) && trim($row[6]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[6])) : null;
        $to_date            = isset($row[7]) && trim($row[7]) != null ? Carbon::createFromFormat('d/m/Y', trim($row[7])) : null;        
        $data = [
            "code"                  => $code ?? null,
            "academic_terms_id"     => $semesters["academy_id"] ?? null,
            "semesters_id"          => $semesters->id ?? null  ,
            "leads_id"              => $leads["id"] ?? null,
            "students_id"           => $students["id"] ?? null,
            "title"                 => $title ?? 'Thông báo đóng học phí',
            "price"                 => $price ?? 0,
            "from_date"             => $from_date ->format('Y-m-d') ?? null,
            "to_date"               => $to_date ->format('Y-m-d')   ?? null,
            "status"                => $status ?? PriceLists::STATUS_NOT_PAID,
            "note"                  => trim($row[9]),
            "created_at"            => Carbon::now() ?? null,
            "created_by"            => Auth::user()->id ?? null,
        ];                
        CreatePriceListJobs::dispatch($data);
        // Data gửi mail
        if(isset($this->auto_send_mail) &&  $this->auto_send_mail  == PriceLists::AUTO_SEND_MAIL) {               
            $file_name = $this->get_file_name();        
            $data_sendmail = [            
                'title'         => "Thông báo học phí " . $title ?? 'Thông báo đóng học phí',
                'subject'       => $title ?? 'Thông báo đóng học phí',
                'full_name'     => $leads['full_name'] ?? null,
                'leads_code'    => $leads['leads_code'] ?? null,
                'phone'         => $leads['phone'] ?? null,
                'price'         => number_format($price) ?? 0,
                "from_date"     => $from_date->format('d/m/Y') ?? null,
                "to_date"       => $to_date->format('d/m/Y') ?? null,
                "status"        => $status ?? PriceLists::STATUS_NOT_PAID,
                'to'            => $leads['email'] ?? null,
                'email'         => $leads['email'] ?? null,
            ];                        
            SendMailJobs::dispatch($data_sendmail,  $file_name);
        }        
    }   
    private function get_data_semesters($semesters_name) {
        $rows = $this->processedRows;                                
        $model = DVLKSemesters::where('types', 0)
                ->where("semesters_name",'LIKE', '%'.$semesters_name.'%')
                ->where('academy_id', $rows["academy_id"]);
        if(in_array($rows["academy_id"],  AcademyList::ACADEMY_BEFORE)) {                    
            $model = $model->where('semesters_to_year',$rows["academy_year"]);
        }
        if(in_array( $rows["academy_id"],  AcademyList::ACADEMY_AFTER)) {                              
            $model = $model->where('semesters_from_year',$rows["academy_year"]);
        }     
        return $model;
    }
    public function rules(): array{   
        $rows = $this->processedRows;  
        return [
            '0' => ['nullable',function ($attribute, $value, $fail) {                 
                $dem = PriceLists::where('code', $value)->count();
                if ($dem > 0) {
                    $fail('Mã học phí '. $value .' đã tồn tại trên hệ thống');
                }
            }],
            '1' => ['required',function ($attribute, $value, $fail) {                                 
                $dem = Leads::where('leads_code', trim($value))->count();
                if ($dem <= 0) {
                    $fail('Mã số sinh viên: ' . $value . ' không tồn tại');
                }
            }], 
            '2' => ['required', function ($attribute, $value, $fail) { 
                $dem = AcademyList::where('name', trim($value))->count();                
                if ($dem <= 0) {
                    $fail('Khóa tuyển sinh không tồn tại');
                }
            }], 
            '3' => ['required'], 
            '4' => ['required', function ($attribute, $value, $fail) use($rows) { 
                $model = $this->get_data_semesters($value)->first();                                
                if (!isset($model->id)) {
                    $fail('Không tìm thấy ' . $value . ' tại '  . $rows["academy_name"] . ' năm ' . $rows["academy_year"]);
                }
            }],
            '5' => ['required'],    
            '6' => ['required'],    
            '7' => ['required'],            
        ];
    }
    public function customValidationMessages()
    {
        return [
            '1.required'        => 'Vui lòng điền đầy đủ Mã số sinh viên',            
            '2.required'        => 'Vui lòng nhập đầy đủ Khóa tuyển sinh',
            '3.required'        => 'Vui lòng nhập đầy đủ Năm tuyển sinh',            
            '4.required'        => 'Vui lòng nhập đầy đủ Học kỳ',      
            '5.required'        => 'Vui lòng nhập đầy đủ Học phí',  
            '6.required'        => 'Vui lòng nhập đầy đủ Ngày bắt đầu',
            '7.required'        => 'Vui lòng nhập đầy đủ Ngày kết thúc',
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
        $data["academy_id"] = $this->get_data_output('academy_list', ["name" => $row[2]], "id");
        $data["academy_year"] = $row[3];
        $data["academy_name"] = $row[2];
        $this->processedRows = $data;        
        return $row;
    }
}
