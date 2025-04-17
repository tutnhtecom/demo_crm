<?php

namespace App\Services\Transactions;

use App\Imports\TranImportCollections;
use App\Imports\TransactionsImportCollections;
use App\Imports\TransactionsImports;
use App\Jobs\CreateMultipleTranslateJob;
use App\Jobs\CreateStudentsJobs;
use App\Jobs\SendMailJobs;
use App\Models\DVLKSemesters;
use App\Models\KpisReports;
use App\Models\Leads;
use App\Models\NotificationsGroups;
use App\Models\PriceLists;
use App\Models\Students;
use App\Models\Transactions;
use App\Models\TransactionStatus;
use App\Repositories\TransactionsRepository;
use App\Services\Leads\LeadsInterface;
use App\Services\Students\StudentsInterface;
use App\Services\Transactions\TransactionsInterface;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class TransactionsServices implements TransactionsInterface{
    use General, Information;
    protected $tran_repository;
    protected $st_interface;
    public function __construct(
        TransactionsRepository $tran_repository,
        StudentsInterface $st_interface
    )
    {
        $this->tran_repository = $tran_repository;
        $this->st_interface = $st_interface;
    }
    public function index($params) {
        try {
            $model = $this->tran_repository->with(['price_lists'])->orderBy('id', 'desc')->get()->toArray();
            if (count($model) > 0) {
                $result = [
                    "code" => 200,
                    "data" => $model
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Hệ thống chưa có bản ghi nào"
                ];
            }
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json(['code' => 422, 'message' => $e->getMessage()]);
        }

    }
    public function details($id) {
       try {
         $model = $this->tran_repository->where('id', $id, '=')->first();
         if(isset($model->id)) {
            $result = [
                "code" => 200,
                "data" => $model
            ];
        } else {
            $result = [
                "code" => 422,
                "message" => "Dữ liệu thêm mới thất bại"
            ];
        }
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json(['code' => 422, 'message' => $e->getMessage()]);
        }
       return response()->json($result);
    }
    public function getDataTransactions($params){
        $tran_date = isset($params["tran_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["tran_date"]))->format('Y-m-d') : Carbon::now()->format('Y-m-d');
        $tran_time = isset($params["tran_time"]) ? Carbon::createFromFormat('H:i', trim($params["tran_time"]))->format('H:i:s') : Carbon::now()->format('H:i:s');
        $params['academic_terms_id'] = DVLKSemesters::where("id", $params['semesters_id'])->first()->academy_id;        
        $data = [
            "name"              => $params["name"],
            "code"              => $params["code"] ?? rand(100000, 999999),
            "leads_id"          => $params["leads_id"],
            "tran_status_id"    => $params["tran_status_id"],
            "tran_types_id"     => $params["tran_types_id"],
            "price_lists_id"    => $params["price_lists_id"],
            "price"             => $params["price"],
            "tran_date"         => $tran_date,
            "tran_time"         => $tran_time,
            "note"              => $params["note"],
            "created_by"        => Auth::user()->id,
            "academic_terms_id" => $params['academic_terms_id'] ?? null,
            "semesters_id"      => $params['semesters_id'] ?? null,
        ];        
        return $data;
    }
    private function multiple_create($params){
        $leads_id = [];
        if(isset($params['groups_id'])) {
            $list_id = $this->get_data_id('notifications_groups', $params['groups_id'], 'list_id');
            $leads_id= explode(',', json_decode($list_id));
        }
        $data = [];
        if(count($leads_id) > 0) {
            foreach ($leads_id as $item) {
                $params['leads_id'] = $item;
                $data[] = $this->getDataTransactions($params);
            }
        }
        $model = $this->tran_repository->createMultiple($data);
        if(count($model) > 0) {
            $this->create_kpi_multiple_reports($model);
            return [
                "code"      => 200,
                "message"   => "Thêm mới thành công"
            ];
        } else {
            return [
                "code"      => 422,
                "message"   => "Thêm mới thành không công"
            ];
        }

    }
    public function create($params){             
        try {
            DB::beginTransaction();
            if (isset($params['groups_id'])) {                    
                $data = $this->multiple_create($params);
            } else {                
                $model = PriceLists::where('id', $params['price_lists_id'])->first();
                $params['name'] = $model['title'];               
                if (!isset($params['semesters_id'])) {
                    $params['semesters_id'] = $model['semesters_id'];
                }
                $data = $this->single_create($params);
            }
            DB::commit();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getLine());
            return [
                "code"      => 422,
                "message"   => $e->getMessage()
            ];
        }
    }
    public function create_multiple($params){
        try {
            DB::beginTransaction();
            // $create = Transactions::insert($params);
            CreateMultipleTranslateJob::dispatch($params);
            DB::commit();
            return [
                "code" => 422,
                "message" => "Success "
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getLine());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
       }
    }
    private function get_path_file($file_name){
        $arr_file = explode('.', $file_name);
        $path = public_path($arr_file[0] .'/'. $arr_file[1] .'/'. $arr_file[2] .'.blade.php');
        return $path;
    }   
    private function create_kpi_multiple_reports($model){
        foreach ($model as $item) {
            $data[] = [
                "employees_id"       =>  $this->get_data_id('leads',$item->leads_id,'assignments_id'),
                "leads_id"           =>  $item['leads_id'],
                "price"              =>  $item->price,
                "date_for_price"     =>  $item->tran_date,
                "status"             =>  $item->tran_status_id,
                "transactions_id"    =>  $item->id,
                "created_at"         =>  Carbon::now()->format('Y-m-d H:i'),
                "created_by"         =>  Auth::user()->id ?? null

            ];
        }
        KpisReports::insert($data);
    }
    private function create_kpi_reports($model){   
        $from_date = $model->semesters->admission_date;
        $to_date   = Carbon::parse($from_date)->addMonths(3)->format('Y-m-d');
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
    public function update($params, $id) {      
        try {
            DB::beginTransaction();
            $tran_date = isset($params["tran_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["tran_date"]))->format('Y-m-d') : Carbon::now()->format('Y-m-d');
            $tran_time = isset($params["tran_time"]) ? Carbon::createFromFormat('H:i', trim($params["tran_time"]))->format('H:i:s') : Carbon::now()->format('H:i:s');;
            $data = [
                "name"              => $params["name"],
                "code"              => $params["code"] ?? rand(100000, 999999),
                "leads_id"          => $params["leads_id"],
                "tran_status_id"    => $params["tran_status_id"],
                "tran_types_id"     => $params["tran_types_id"],
                "price_lists_id"    => $params["price_lists_id"],
                "price"             => $params["price"],
                "tran_date"         => $tran_date,
                "tran_time"         => $tran_time,
                "note"              => $params["note"],
                "updated_by"        => Auth::user()->id,
            ];
            $model = $this->tran_repository->updateById($id, $data);           
            $result = null;
            if(isset($model->id)) {                
                $id_student = null;
                $email  = $this->get_data_id('leads', $data['leads_id'], 'email');
               
                if($model->tran_status_id == Transactions::TRANS_COMPLETE) {                    
                    $priceListId = PriceLists::where('id', $params['price_lists_id'])->first();
                    if(!isset($params['academic_terms_id'])){
                        $params['academic_terms_id'] = $priceListId['academic_terms_id'];
                    }
                    if(!isset($params['semesters_id'])){
                        $params['semesters_id'] = $priceListId['semesters_id'];
                    }
                    $data_students  = $this->get_data_for_students($data['leads_id']);
                    $students = Students::create($data_students);
                    $data_relationship = [
                        $students['leads_id'] => $students['id']
                    ];
                    $this->update_multiple_relationship($data_relationship);
                    Leads::where('id', $params['leads_id'])->update([
                        "academic_terms_id"     => $params['academic_terms_id'],
                        "active_student"        => Leads::ACTIVE_STUDENTS
                    ]);
                    $id_student = Students::where('email', $email)
                    ->whereNull('deleted_at')
                    ->value('id');                 
                    // Gửi mail
                    $file_name = $this->get_file_name($params, 'includes.crm.thong_bao_hoan_thanh_hoc_phi');                                        
                    $status_file = view()->exists($file_name);
                    if ($status_file) {
                        // Kiểm tra file có tồn tại
                        $data_sendmail = [
                            'title'         => 'Hoàn thành học phí',
                            'subject'       => 'Hoàn thành học phí',
                            'full_name'     => $full_name ?? null,
                            'leads_code'    => $leads_code ?? null,
                            'price'         => isset($data['price']) ? number_format($data['price']) : 0,
                            "tran_date"     => $params['tran_date'] ?? null,
                            "tran_time"     => $params['tran_time'] ?? null,
                            "status"        => $params['status'] ?? null,
                            'to'            => $email,
                            'email'         => $email,
                        ];
                        SendMailJobs::dispatch($data_sendmail,  $file_name);
                        $result = [
                            "code"          => 200,
                            "message"       => "Dữ liệu đã được thêm mới thành công",
                            "id_student"    => $id_student,
                        ];
                    } else {
                        $result = [
                            "code" => 200,
                            "message" => "Gửi mail thất bại"
                        ];
                    }
                }

                // Update status trong kpis status
                KpisReports::where('transactions_id', $model->id)->update([
                    "status"  => $model->tran_status_id,
                    "price"   => $model->price,
                ]);
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được cập nhật thành công",
                    "id_student"    => $id_student,
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu cập nhật thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {            
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
       }
    }
    private function delete_status($id){
        $status = false;
        $dem = Transactions::where('id', $id)->whereNotNull('leads_id')->whereNotNull('students_id')->count();
        if($dem > 0)
        return $status;
    }
    public function delete($id) {
        try {
            DB::beginTransaction();
            $data = [
                'deleted_at' => Carbon::now()->format('Y-m-d'),
                'deleted_by' => Auth::user()->id ?? null
            ];
            // Kiểm tra trước khi xóa
            // $status = $this->delete_status($id);
            // if($status == true) {
            //     $result = [
            //         "code" => 422,
            //         "message" => "Giao dịch này không thể xóa"
            //     ];
            // }
            $model = $this->tran_repository->updateById($id, $data);
            $result = null;
            if(isset($model->id)) {
                $reports = KpisReports::where('transactions_id', $model->id)->first();
                if(isset($reports->id)) {
                    $reports->update($data);
                }
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được xóa thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu xóa thất bại"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }

    }
    public function createMultiple($params){
        try {
            DB::beginTransaction();
            $list_id = null;
            if(isset($params['groups_id'])) {
                $groups = NotificationsGroups::where('id', $params['groups_id'])->first();
                $list_id = explode(',', json_decode($groups['list_id']));
            }
            $data = [];
            $tran_date    = Carbon::createFromFormat('d/m/Y', $params['tran_date'])->format('Y-m-d');
            $params['tran_date'] = $tran_date;
            $tran_time    = Carbon::createFromFormat('H:i', $params['tran_time'])->format('H:i');
            $params['tran_time'] = $tran_time;
            foreach ($list_id as $value) {
                $params['leads_id']      = $value;
                $params['code']          = rand(100000, 999999);
                $params['created_at']    = Carbon::now()->format('Y-m-d H:i');
                $params['created_by']    = Auth::user()->id;
                $data[] = $params;
            }
            
            $model = $this->tran_repository->createMultiple($data);
            if(count($model) > 0) {
                $this->create_kpi_multiple_reports($model);
                $result = [
                    "code"      => 200,
                    "message"   => "Tạo nhiều giao dịch thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Tạo nhiều giao dịch không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }

    }
    public function import_excel($params){         
        try {
            // DB::beginTransaction();
            if(!isset($params['file'])){
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn file import"
                ];
            }      
            if(!isset($params["auto_send_mail"]))  $params["auto_send_mail"] = 0;
            Excel::import(new TransactionsImports($params["auto_send_mail"]), $params['file']);                 
            // DB::commit();
            return response()->json([
                "code" => 200,
                "message" => "Import Excel thành công"
            ]);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();                          
            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            // DB::rollBack();
            return [
                "code" => 422,
                "message" => $failures
            ];
        }
    }
    // Single create
    // ------------------------------------------------------------------------------
    public function check_transactions($params){                
        // Gán trạng thái nhỏ hơn cho phép thêm mới
        $status = Transactions::LESS; // Nhỏ hơn
        // Kiểm tra tiền trong bảng giá
        $total_price_list = PriceLists::where('id', $params['price_lists_id'])->first()->price ?? 0;
        $price_transactions = Transactions::where('leads_id', $params['leads_id'])
                            ->where('price_lists_id', $params['price_lists_id'])
                            ->groupBy('price_lists_id')
                            ->select(DB::raw('sum(price) as total'))->first() ?? 0;
        if(isset($price_transactions['total'])) $total_price = $price_transactions['total'] + $params['price'];
        else $total_price = 0 + $params['price'];
        if($total_price >  $total_price_list) $status = Transactions::GREATE; //Lớn hơn
        return $status;
    }
    private function create_transaction($data){
        $data['types_id'] = 3;                    
        $model = $this->tran_repository->with(['leads.employees', 'semesters'])->create($data);           
        return $model;
    }
    private function action_sendmail($params){        
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
            'content'       => $params["content"] ?? null,
        ];          
        SendMailJobs::dispatch($data_sendmail,$params["file_name"]);
    }
    private function single_create($params) {        
        // Khai báo biến
        $result             = null;
        $students           = null;
        $data_relationship  = null;        
        $data               = $this->getDataTransactions($params);            
        $status             = $this->check_transactions($data);             
        //Kiểm tra số tổng số tiền đóng vói số tiền ở báo giá
        if ($status == Transactions::GREATE) {
            return [
                "code"      => 422,
                "message"   => Transactions::COMPARE_MAP[$status]
            ];
        }        
        $data['types_id'] = 3;                    
        $model = $this->tran_repository->with(['leads.employees', 'semesters'])->create($data);                  
        // Get danh sach leads
        if (isset($model->id)) {  
            // Kết quả tạo giao dịch thành công       
            $leads = $model['leads'];                  
            // Giao dịch hoàn thành
            if($model->tran_status_id == Transactions::TRANS_COMPLETE) {
                $file_name = $this->get_file_name($params, 'mau_thong_bao_hoan_thanh_dong_hoc_phi');
                // Chuyển đổi sinh vien tiềm năng sang  sinh viên chính thức
                $students  = $this->convert_leads_to_students($leads);                
                $data_relationship = [
                    $students['leads_id'] => $students['id']
                ];                
                $this->update_multiple_relationship($data_relationship);
                // Leads::where('id', $params['leads_id'])->update([ "active_student" => Leads::ACTIVE_STUDENTS]);                
                $leads->update([ "active_student" => Leads::ACTIVE_STUDENTS]);
                
                // Gửi mail
                if(isset($params["auto_send_mail"]) && $params["auto_send_mail"] == PriceLists::AUTO_SEND_MAIL && isset($leads->email)) {                                                
                    $send = [
                        'title'         => 'Thông tin hoàn thành học phí',
                        'subject'       => 'Thông tin hoàn thành học phí',                          
                        'full_name'     => $leads->full_name ?? '',
                        "email"         => $leads->email ?? '',                        
                        "leads_code"    => $leads->leads_code,
                        "phone"         => $leads->phone,
                        'price'         => isset($data['price']) ? number_format($data['price'], 0, ',','.') : 0,
                        "tran_date"     => $params['tran_date'] ?? null,
                        "status"        => Transactions::TRANS_MAP[$params["tran_status_id"]],
                        "file_name"     => $file_name ?? 'mau_thong_bao_hoan_thanh_dong_hoc_phi'
                    ];                                                       
                    $this->action_sendmail($send);    
                }                                
                // Bổ sung kpis
                $this->create_kpi_reports($model);
                // Bổ sung gửi email cho nhân viên phụ trách
                if(isset($params["auto_send_mail"]) && $params["auto_send_mail"] == PriceLists::AUTO_SEND_MAIL ){
                    if(isset($params['e_file_name'])) {
                        $e_file_name = 'includes.template' . $params['e_file_name'];   
                    } else {
                        $e_file_name   =  "includes.crm.mau_thong_bao_giao_dich_cho_nhan_vien_phu_trach" ;
                    }                
                    $status =  view()->exists($e_file_name);
                    if($status && isset($leads->employees)) {
                        $e_send = [
                            'title'         => 'Thông báo kết quả KPIS đạt được',
                            'subject'       => 'Thông báo kết quả KPIS đạt được',   
                            'content'       => 'Sinh viên ' . $leads->full_name . ' hoàn thành học phí. Bạn đạt được Kpis học phí: ' . number_format($data['price']),
                            'email'         => $leads->employees->email ?? null,
                            "file_name"     => $e_file_name
                        ];                      
                        $this->action_sendmail($e_send);                    
                    } 
                }
            }       

            // Bổ sung báo cáo kpi cho giao viên            
            $result = [
                "code"          => 200,
                "message"       => "Dữ liệu đã được thêm mới thành công",
                "data"          => $model,
                "student"       => $students,
            ];
        } else { // Kết quả thêm mới thất bại
            $result = [
                "code" => 422,
                "message" => "Dữ liệu thêm mới thất bại"
            ];
        }
        return response()->json($result);
    }
    private function get_data_for_students($id){
        $model = Leads::with(['students', 'contacts', 'files', 'family'])->where('id', $id)->first()->toArray();
        $data = $this->st_interface->get_data_student($model);
        return $data;
    }
    // Get data students
    private function convert_leads_to_students($model){        
        $data = $this->st_interface->get_data_student($model);          
        $students = Students::create($data);       
        return $students;        
    }

    // ------------------------------------------------------------------------------
}
