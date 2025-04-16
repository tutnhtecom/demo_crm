<?php

namespace App\Services\Kpis;

use App\Jobs\AutoNotificationExpiredKpisJobs;
use App\Jobs\CreateNotificationsJobs;
use App\Jobs\DeleteKpisJob;
use App\Jobs\SendMailJobs;
use App\Models\ConfigGeneral;
use App\Models\DVLKSemesters;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Kpis;
use App\Models\KpisStatus;
use App\Models\Notifications;
use App\Repositories\KpisRepository;
use App\Repositories\MarjorsRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KpisServices implements KpisInterface
{    
    protected $kpis_repository;
    public function __construct(KpisRepository $kpis_repository)
    {
        $this->kpis_repository = $kpis_repository;
    }
    private function delete_kpi_by_month(){
        $model = Kpis::whereMonth('created_at',  Carbon::now()->format('m'))->first();                
        if(isset($model->id)) {
            $model->delete();
        }
    }
    public function create($params){       
        try {
            DB::beginTransaction();                    
            $data = [];
            $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            $end_date = Carbon::now()->endOfMonth()->format('Y-m-d');            
            if(count($params["data"]) > 0) {
                foreach ($params["data"] as $item) {
                    $item["from_date"] = $from_date;
                    $item["to_date"] = $end_date;
                    $item["created_by"] = Auth::user()->id ?? NULL;
                    $data[] = $item;
                }
            }            
            $result = null;
            if (count($data) > 0) {
                $model = $this->kpis_repository->createMultiple($data);
                if (isset($params['status'])) {
                    $this->delete_kpi_by_month();
                    DB::table('kpis_status')->insert(['status' => $params['status']]);
                }
                if (count($model) > 0) {
                    $result = [
                        "code" => 200,
                        "message" => "Dữ liệu đã được thêm mới thành công"
                    ];
                } else {
                    $result = [
                        "code" => 422,
                        "message" => "Dữ liệu thêm mới thất bại"
                    ];
                }
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Chi tiêu trong tháng này đã có"
                ];
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function update($params){   
        // dd($params);
        try {
            DB::beginTransaction();
            $data = $params['data'];            
            $from_date = Carbon::now()->startOfMonth()->format('Y-m-d');
            $end_date = Carbon::now()->endOfMonth()->format('Y-m-d');
            $data_insert = [];
            foreach ($data as $item) {                   
                $item["from_date"] = isset($item["from_date"]) ? Carbon::createFromFormat('d/m/Y', $item["from_date"])->format('Y-m-d')  : $from_date;
                $item["to_date"] = isset($item["to_date"]) ? Carbon::createFromFormat('d/m/Y', $item["to_date"])->format('Y-m-d') : $end_date;
                $item["updated_by"] = Auth::user()->id ?? NULL;
                $item["semesters_id"] =  $item["semester_id"] ?? null;                
                $data_insert[] = $item;
                $model = Kpis::where("semesters_id", $item["semesters_id"])
                              ->where('employees_id', $item["employees_id"])  
                              ->delete();                              
            }            
            // ->where("from_date", '<=', $item["from_date"])->where("to_date", ">=", $item["to_date"] )
            $model = $this->kpis_repository->createMultiple($data_insert);
            $result = null;
            if (count($model) > 0) {
                if (isset($params['status'])) {
                    DB::table('kpis_status')->delete();
                    DB::table('kpis_status')->insert(['status' => $params['status']]);
                }
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật chỉ tiêu tuyển sinh thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Cập nhật chỉ tiêu tuyển sinh không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json(['code' => 422, 'message' => $e->getMessage()]);
        }
    }
    private function  get_first_data_semesters(){
        $model = DVLKSemesters::where('types' , 0)->first();
        return $model->id ?? '';
    }
    private function filter($params){       
        $model = $this->kpis_repository->with(['employees.roles']);        
        if(isset($params["semesters_id"])) {
                $model = $model->where('semesters_id', $params["semesters_id"]);
        } else {
            $semesters_id = $this->get_first_data_semesters();            
            $model = $model->where('semesters_id', $semesters_id);          
        }        
        $model = $model->orderBy('id', 'desc');                
        return $model;
    }    
    public function get_data_kpis($params){
       
        $model = $this->filter($params)->get()->toArray();        
        $data = [];           
        foreach ($model as $value) {
            $data[$value["employees_id"]] = $value;
        }                
        return $data;
    }
    public function data($params)
    {
        $model = $this->filter($params)->get();        
        if (count($model) > 0) {
            return [
                "code"  =>  200,
                'data'  =>  $model
            ];
        } else {
            return [
                "code"      =>  200,
                'message'   =>  "Không tìm thấy bản ghi nào"
            ];
        }
    }
    public function details($id)
    {
        $model = $this->kpis_repository->with(['employees'])->where('id', $id)->first();
        if (isset($model->id)) {
            return [
                "code"  =>  200,
                'data'  =>  $model
            ];
        } else {
            return [
                "code"      =>  200,
                'message'   =>  "Không tìm thấy bản ghi nào"
            ];
        }
    }
    private function get_expired_date(){
        $config = ConfigGeneral::where('types', ConfigGeneral::TYPES_KPIS)->first();        
        return $config;
    }
    private function check_exist_data_this_month(){
        $dem = Kpis::whereMonth('to_date',  Carbon::now()->format('m'))->orderBy('created_at', 'desc')->count();        
        if ($dem > 0) return true;
        else return false;
    }
    public function cron_data(){
        $data_next_month = [];
        $now =  Carbon::now();
        $status = $this->check_exist_data_this_month();        
        $check = false;       
        if (!$status) {            
            $model = Kpis::select(['employees_id', 'price', 'quantity', 'from_date', 'to_date'])
                    ->whereMonth('to_date', $now->subMonth()->format('m'))
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();            
            if (count($model) > 0) {
                $next_month = KpisStatus::where('status', KpisStatus::ACTIVE)->first();
                $from_date  = Carbon::now()->startOfMonth()->format('Y-m-d');
                $to_date    = Carbon::now()->endOfMonth()->format('Y-m-d');
                if (isset($next_month->id)) {
                    foreach ($model as $value) {
                        $value["from_date"] = $from_date;
                        $value["to_date"]   = $to_date;
                        $value["created_by"]   = Auth::user()->id ?? null;
                        $value["created_at"]   = Carbon::now()->format('Y-m-d H:i:s');
                        $data_next_month[] = $value;
                    }
                    Kpis::insert($data_next_month);
                }
                $check = true;
            } else {
                $check = false;
            }
        } else {
            $check = false;
        }
        $result = null;
        if($check) {
            $result = [
                "code"      => 200,
                "message"   => "Tự động tạo kpis mới thành công"
            ];
        } else {
            $result = [
                "code"      => 422,
                "message"   => "Tự động tạo kpis mới không thành công"
            ];
        }
        return $result;
    }
    private function get_file_name_by_email_template($types){
            $title = 'Mẫu thông báo kpis';
            $model = EmailTemplates::where('types_id', EmailTemplateTypes::TYPE_KPIS)->where('is_default', 1)
                        ->orwhere('title', 'like', '%'.$title.'%')
                        ->orWhere('title', 'like', '%kpis%')
                        ->first();                
            $file_name = null;
            if(isset($model->file_name)) $file_name = 'includes.template.' . $model->file_name ;
            else $file_name = 'includes.crm.mau_thong_bao_kpi_het_han';           
            return $file_name;
    }
    public function create_notification_kpis_expired(){
        try {
            DB::beginTransaction();            
            $file_name = $this->get_file_name_by_email_template(5);       
            $config                 = $this->get_expired_date();            
            $data_notification      = [];
            $kpis                   = Kpis::with(['employees'])->orderBy('employees_id', 'desc')
                                    ->whereMonth('to_date', Carbon::now()->format('m'))
                                    ->get()->toArray();
            $m_year_current         = Carbon::now()->format('m/Y');            
            $title                  = "Hệ thống thông báo kỳ hạn thực hiện chỉ tiêu tuyển sinh";
            $data_sendmail          = null;            

            if (count($kpis) > 0 && ($config["current_month"] == null ||  $config["current_month"] != $m_year_current)) {
                foreach ($kpis as $k) {
                    $kpis_this_year     =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('Y'); // Lấy năm
                    $kpis_this_month    =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('m'); // Lấy tháng
                    $kpis_this_day      =  Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('d'); // Lấy ngày                    
                    $expired_day        =  $kpis_this_day - Carbon::now()->format('d'); // Thời gian khóa 

                    $content            =  "Chỉ tiểu tuyển sinh tháng " . Carbon::now()->format('m') . "/" . Carbon::now()->format('Y') . " của bạn cần đạt: Tổng doanh thu: " . number_format($k["price"], 0, ',', '.') . " - Tổng sinh viên: " . $k["quantity"] . "/người hết hạn vào ngày " . $k["to_date"];
                    $email              =  $k["employees"]["email"] ?? null;                                      
                    if(($kpis_this_year == Carbon::now()->format('Y')) && ($kpis_this_month == Carbon::now()->format('m')) && ($expired_day <=  $config['end_date'])) {
                        $data_notification      = [
                            "email"             =>   $email,
                            "topic"             =>    $title,
                            "title"             =>    $title,
                            "content"           =>    $content,
                            "obj_types"         =>    2,
                            "send_types"        =>    2,
                            "status"            =>    1,
                            "is_open"           =>    0,
                            "created_at"        =>    Carbon::now(),
                            "created_by"        =>    Auth::user()->id ?? null
                        ];

                        CreateNotificationsJobs::dispatch($data_notification);
                        $data_sendmail = [
                            "title"         => $title,
                            'subject'       => $title,
                            "content"       => $content,
                            'to'            => $email,
                            'email'         => $email,
                        ];                                          
                        SendMailJobs::dispatch($data_sendmail, $file_name);
                    }                    
                }      
                $data = [
                    "current_month" => Carbon::createFromFormat('Y-m-d', $k['to_date'])->format('m/Y')
                ];
                ConfigGeneral::where('types', ConfigGeneral::TYPES_KPIS)->update($data);
            }            
            DB::commit();
            // AutoNotificationExpiredKpisJobs::dispatch();       
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
}
