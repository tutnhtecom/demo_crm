<?php

namespace App\Imports;

use App\Jobs\CreateMultipleTranslateJob;
use App\Jobs\CreateStudentsJobs;
use App\Jobs\SendMailJobs;
use App\Models\AcademicTerms;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\KpisReports;
use App\Models\Leads;
use App\Models\Notifications;
use App\Models\PriceLists;
use App\Models\Semesters;
use App\Models\Students;
use App\Models\Transactions;
use App\Models\TransactionStatus;
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
use Symfony\Component\Mailer\Transport\Transports;

// WithValidation
class TransactionsImports implements ToModel, WithStartRow, WithChunkReading, SkipsEmptyRows, WithValidation
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
        return 2;
    }
    public function chunkSize(): int
    {
        return 400;
    }
    private function get_tran_satus_id($row) {
        $status_id = 0;        
        if(isset($row[7])) {
            $model = TransactionStatus::where("name", trim($row[7]))->first();
            if(isset($model->id)) {
                $status_id = $model->id;
            }
        }
        return $status_id;
    }
    private function get_data_students($table, $condition, $row) {        
        if(strlen($row[1]) <= 0) {
            return [
                "code"      => 422,
                "message"   => "Vui lòng nhập Mã số sinh viên"
            ];
        }
        $id = $this->get_data_by_output($table, $condition, "id");        
        return $id;
    }
    private function get_data_max_id(){
        $max_id = $this->get_next_id("transactions");
        return $max_id;
    }
    private function check_price_list($code, $price){            
        $status = true;
        $model = PriceLists::where("code", $code)->first()->toArray();                
        if($price > $model["price"]) {               
            $status = false;
        }                    
        return $status;
    }    
    private function update_active_students($leads_id){
        $data = Leads::where('id', $leads_id)->update([ "active_student" => Leads::ACTIVE_STUDENTS]);
        return $data;
    }
    private function action_sendmail($params, $types = null){                           
        $data_sendmail = [
            'title'         => $params["title"] ?? null,
            'subject'       => $params["subject"] ?? null,
            'full_name'     => $params["full_name"] ?? null,
            'leads_code'    => $params["leads_code"] ?? null,
            'price'         => $params['price'] ?? 0,
            'phone'         => $params['phone'] ?? 0,
            'tran_date'     => $params['tran_date'] ?? null,                            
            'status'        => $params['status'] ?? null,
            'to'            => $params["email"] ?? null,
            'email'         => $params["email"] ?? null,
        ];                 
        if($types == 2){                       
            $data_sendmail[ 'content'] = $params["content"] ?? null;            
        }
        
        SendMailJobs::dispatch($data_sendmail,$params["file_name"]);
    }
    private function get_file_name($types_id) {        
        $file_name = $this->get_data_file_name_by_types($types_id);      
        return $file_name;
    }
    private function update_status_price_lists($id){
        $model = PriceLists::where('id', $id )->update([
            "status" => PriceLists::STATUS_PAID
        ]);
        return $model;
    }
    public function model(array $row){
        $price_lists    = $this->get_data_price_list($row);   
        if(!isset($price_lists["id"])){
            return false;
        }
        $semesters_name = $price_lists["semesters"]["semesters_name"] ?? null;
        $semesters_id   = $price_lists["semesters"]["id"] ?? null;
        $code           = rand(100000,999999);
        $name           = isset($row[2]) ? trim($row[2]) : 'Học phí ' .  trim($semesters_name); // Tên giao dịch
        $price_lists_id = $price_lists["id"];
        $price          = trim($row[4]);        
        $status         = $this->get_tran_satus_id($row);         
        $leads_id       = (int)$price_lists['leads_id'] ?? null;
        $students_id    = (int)$price_lists['students_id'] ?? null;
        $tran_type_id   = $this->get_data_by_output("transactions_types", ["name" => trim($row[5])], "id");
        $tran_date      = isset($row[6]) && strlen($row[6]) ? Carbon::createFromFormat('d/m/Y', trim($row[6]))->format('Y-m-d') : Carbon::now()->format("Y-m-d");
        $data = [
            "name"                      => $name ?? null, // Tên giao dịch
            "code"                      => $code ?? null, // Mã giao dịch
            "price_lists_id"            => $price_lists_id ?? null, // Mã hóa đơn                    
            "semesters_id"              => $semesters_id ?? null, // Học kỳ theo niên khóa
            "price"                     => $price ?? 0, // Học phí
            "tran_status_id"            => $status ?? null, // Trạng thái
            "leads_id"                  => $leads_id ?? null, // Id sinh viên tiềm năng
            "students_id"               => $students_id ?? null, // Id sinh viên chính thức
            "tran_types_id"             => $tran_type_id ?? null, // Kiểu giao dịch
            "tran_date"                 => $tran_date ?? null, // Ngày giao dịch
            "tran_time"                 => Carbon::now()->format("H:i"), // Thời gian đóng
            "note"                      => trim($row[8]) ?? '', // Ghi chú
            "created_at"                => Carbon::now(), // Thời gian tạo
            "created_by"                => Auth::user()->id, // Người tạo
        ];        
        // JOb them moi giao dich
        $model = Transactions::with(['leads.employees', 'semesters'])->create($data);                
        // CreateMultipleTranslateJob::dispatch($data);        
        if($status == Transactions::TRANS_COMPLETE) {
            // Thực hiện update price list
            $this->update_status_price_lists($model->price_lists_id);
            // Chuyen doi sinh vien tiem nang sang chinh thuc
            $data_students = $this->get_data_student($price_lists['leads']);            
            $check_status = $this->check_exists_students($data_students);
            if($check_status == false) {
                Log::info($data_students["email"] . ' ' . $data_students["marjors_id"]);
                // CreateStudentsJobs::dispatch($data_students);
                Students::create($data_students);
            }            
            // Update active studetns in leads
            $this->update_active_students($leads_id);
            // Update cac bang lien quan de update truong students_id
            $data_relationship = [
                "leads_id" => $leads_id,
                "id"       =>  Students::max("id") + 1
            ];
            $this->update_multiple_relationship($data_relationship);
            // Send mail tới sinh viên             
            if(isset($this->auto_send_mail) &&  $this->auto_send_mail  == PriceLists::AUTO_SEND_MAIL) {    
                $s_file_name = $this->get_file_name(EmailTemplateTypes::TYPE_TRANSACTIONS);                        
                $send = [
                    'title'         => 'Thông tin hoàn thành học phí',
                    'subject'       => 'Thông tìn hoàn thành học phí',                          
                    'full_name'     => $price_lists->leads->full_name ?? null,
                    "email"         => $price_lists->leads->email ?? null,
                    "leads_code"    => $price_lists->leads->leads_code ?? null,
                    "phone"         => $price_lists->leads->phone ?? null,
                    'price'         => isset($price) ? number_format($price, 0, ',','.') : 0,
                    "tran_date"     => $tran_date ?? null,
                    "status"        => Transactions::TRANS_MAP[$status],
                    "file_name"     => $s_file_name ?? 'mau_thong_bao_hoan_thanh_dong_hoc_phi'
                ];                          
                $this->action_sendmail($send, null); 
                 // Gửi mail tới Giáo viên                       
                $e_file_name = $this->get_file_name(EmailTemplateTypes::TYPE_KPIS);            
                $e_send = [
                    'title'         => 'Thông báo kết quả KPIS đạt được',
                    'subject'       => 'Thông báo kết quả KPIS đạt được',   
                    'content'       => 'Sinh viên ' . $price_lists->leads->full_name . ' hoàn thành học phí. Bạn đạt được Kpis học phí: ' . number_format($price),
                    'email'         => $price_lists->leads->employees->email,
                    "file_name"     => $e_file_name ?? "includes.crm.mau_thong_bao_giao_dich_cho_nhan_vien_phu_trach",
                    "obj_types"     => Notifications::OBJECT_EMPLOYEES
                ];             
                $this->action_sendmail($e_send, Notifications::OBJECT_EMPLOYEES);
            } 
            // Thiết lập KPIS
            $this->create_kpi_reports($model);
        }
    }  
    private function check_exists_students($data){        
        $status = false;
        $e_count = Students::where('email', $data["email"])->where('marjors_id', $data["marjors_id"])->count();
        if($e_count > 0) $status = true;
        else {
            $p_count = Students::where('phone', $data["phone"])->where('marjors_id', $data["marjors_id"])->count();
            if($p_count > 0) $status = true;
        }
        return $status;
    }
    private function create_kpi_reports($model){
        $from_date = $model->semesters->admission_date;
        $to_date   = Carbon::parse('2024-03-21')->addMonths(3)->format('Y-m-d');
        $data = [
            "employees_id"      =>  $model->leads->assignments_id ?? ($model['leads']['assignments_id'] ?? null),
            "leads_id"          =>  $model->leads->id ?? ($model['leads']['assignments_id'] ?? null),
            "transactions_id"   =>  $model->id ?? ($model['id'] ?? null),
            "price"             =>  $model->price ??($model['price'] ?? 0),
            "date_for_price"    =>  $model->tran_date ?? ($model['date_for_price'] ?? null),
            "status"            =>  $model->tran_status_id ?? ($model['tran_status_id'] ?? null),
            "academy_list_id"   =>  $model->academic_terms_id,
            "semesters_id"      =>  $model->semesters_id,
            "semesters_name"    =>  $model->semesters->semesters_name,
            "from_date"         =>  $from_date ?? null,
            "to_date"           =>  $to_date ?? null
        ];                
        $model = KpisReports::create($data);        
        return $model;
    }   
    private function get_send_mail($transactions, $status) {
        $email          = $transactions["leads"]["email"];
        $full_name      = $transactions["leads"]["full_name"];
        $leads_code     = $transactions["leads"]["leads_code"];
        $file_name      = "includes.crm.thong_bao_hoan_thanh_hoc_phi";
        $status_file    = view()->exists($file_name);        
        if ($status_file) {
            // Kiểm tra file có tồn tại
            $data_sendmail = [
                'title'         => 'Hoàn thành học phí',
                'subject'       => 'Hoàn thành học phí',
                'full_name'     => $full_name ?? null,
                'leads_code'    => $leads_code ?? null,
                'price'         => isset($data['price']) ? number_format($data['price']) : 0,
                "tran_date"     => $data['tran_date'] ?? null,
                "tran_time"     => $data['tran_time'] ?? null,
                "status"        => $status,
                'to'            => $email,
                'email'         => $email,
            ];               
            SendMailJobs::dispatch($data_sendmail,  $file_name);                   
        }
    } 
    public function rules(): array{        
       
        return [
            '1' => ['required',function ($attribute, $value, $fail) {                 
                $dem = Leads::where('leads_code', trim($value))->count();
                if ($dem <= 0) {
                    $fail('Mã số sinh viên: ' . $value . ' không tồn tại');
                }
            }], 
            '2' => ['required'], 
            '3' => ['required', function ($attribute, $value, $fail) {                 
                $dem = PriceLists::where('code', trim($value))->count();
                if ($dem <= 0) {
                    $fail('Mã học phí: ' . $value . ' không tồn tại');
                }
                $data = $this->processedRows;
                $data['code'] = $value;
                $status = $this->check_total_price($data);                
                if($status == Transactions::GREATE) {
                    $fail("Tổng hợp phí đã lớn hơn số tiền cần phải đóng");
                }
            }], 
            '4' => ['required', function ($attribute, $value, $fail) {
                if ($value < 0) {
                    $fail('Học phí phải lơn hơn 0');
                }
            }], 
            '5' => ['required'],
            '6' => ['required']
        ];        
        // return $rules;
    }
    public function customValidationMessages(){
        return [
            // Mã nhân viên
            '1.required'        => 'Vui lòng điền đầy đủ Mã số sinh viên',            
            // Niên khóa
            '2.required'        => 'Vui lòng nhập đầy đủ Tên niên khóa',
            // Học kỳ
            '3.required'        => 'Vui lòng nhập đầy đủ Học kỳ',            
            // Học phí
            '4.required'        => 'Vui lòng nhập đầy đủ Học phí',        
            // Ngày bắt đầu
            '5.required'        => 'Vui lòng nhập đầy đủ Ngày bắt đầu',
            // Ngày kết thúc
            '6.required'        => 'Vui lòng nhập đầy đủ Ngày kết thúc',
        ];
    }
    private function get_data_price_list($row){
        $model = PriceLists::with(['semesters'])->whereHas('leads', function ($q) use($row) {            
                    $q->where('leads_code', $row[1]);
                })->where('code', trim($row[3]))->first();
        return $model;
    }
    private function get_price_list($data){        
        // Lấy danh sách theo điều kiện
        $price_lists = PriceLists::with(['semesters'])->whereHas('leads', function ($q) use($data) {            
            $q->where('leads_code', $data['students_code']);
        })->where('code', $data['code'])->first();
        return $price_lists;
    }
    private function check_total_price($data){                     
        $price_lists = $this->get_price_list($data);
        if(!isset($price_list["id"])) {
            return false;
        }        
        // Lấy tiền từ bảng pricelist cần đóng
        $price = $price_lists["price"];                
        $price_lists_id = $price_lists["id"];        
        $leads_id = $price_lists["leads_id"];
        $status = Transactions::LESS; //Lớn hơn
        $price_transactions = Transactions::where('leads_id', $leads_id)
            ->where('price_lists_id', $price_lists_id)
            ->groupBy('price_lists_id')
            ->select(DB::raw('sum(price) as total'))
            ->first() ?? 0;
        if(isset($price_transactions['total'])) $total_price = $price_transactions['total'] + $data['price'];
        else  $total_price = $price_transactions + $data['price'];

        if($total_price >  $price) $status = Transactions::GREATE; //Lớn hơn                  
        return $status;
    }
    public function getProcessedRows(){   
        return $this->processedRows;
    }    
    public function prepareForValidation(array $row): array
    {
        $data["students_code"] = $row[1];        
        $data["price"] = $row[4];                
        $this->processedRows = $data;        
        return $row;
    }
}
