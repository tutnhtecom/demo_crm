<?php

namespace App\Services\Supports;

use App\Exports\SupportsExports;
use App\Jobs\SendMailJobs;
use App\Jobs\UpdateReplationshipJobs;
use App\Models\ConfigGeneral;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\Employees;
use App\Models\Files;
use App\Models\Supports;
use App\Models\SupportsStatus;
use App\Repositories\FilesRepository;
use App\Repositories\SupportsRepository;
use App\Services\Supports\SupportsInterface;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class SupportsServices implements SupportsInterface
{   
    use General, Information; 
    protected $sp_repository;
    protected $file_repository;
    public function __construct(
        SupportsRepository $sp_repository,
        FilesRepository $file_repository
    ) {
      $this->sp_repository = $sp_repository;   
      $this->file_repository = $file_repository;   
    }
    public function filter($params) {
        $model = Supports::with('status', 'leads.files', 'employees', 'tags', 'files');
        if (isset($params['sort'])) {
            switch ($params['sort']) {
                case 'desc':
                    $model = $model->orderBy('created_at', 'desc');
                    break;
                case 'asc':
                    $model = $model->orderBy('created_at', 'asc');
                    break;
                default:
                    $model = $model->orderBy('id', 'desc');
                    break;
            }            
        } else {
            $model = $model->orderBy('id', 'desc');
        }     
        
        if(isset($params['keyword']) && strlen($params['keyword']) > 0) {
            $model = $model->whereHas('leads', function ($q) use ($params) { 
                $q->where('full_name', 'LIKE', '%'. $params['keyword'] .'%')                  
                  ->orWhere('phone', $params['keyword'])
                  ->orWhere('email', $params['keyword']);
            }); 
        }
        if (isset($params['sp_status_id'])) {
            $model = $this->filter_where_all($model, $params['sp_status_id'], 'sp_status_id');
        } 
        if (isset($params['priority_level'])) {
            $model = $this->filter_where_all($model, $params['priority_level'], 'priority_level');
        }
        if (isset($params['employees_id'])) {
            $model = $this->filter_where_all($model, $params['employees_id'], 'employees_id');
        }
        if (isset($params['from_date'])) {
            $from_date = Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->startOfDay()->format('Y-m-d H:i:s');;
            $model = $model->where('created_at', '>=', $from_date);
        }
        if (isset($params['to_date'])) {
            $to_date = Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->endOfDay()->format('Y-m-d H:i:s');;
            $model = $model->where('created_at', '<=', $to_date);
        }       
        return $model;
    }
    private function filter_where_all($model, $param, $name){
        if (is_array($param)) {
            if(!in_array('all',$param)){
                $model = $model->whereIn($name, $param);
            }
        } else {
            if($param !== 'all'){
                $model = $model->where($name, $param);
            }
        }
        return $model;
    }   
    public function index($params){
        try {            
            $record = $params['record'] ?? 15;
            $entries = $this->filter($params)->get();
            $result = [
                "code" => 200,
                "data" => $entries
            ];           
            return $result;
        } catch (\Exception $e) {            
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
    }
    public function details($id) {
        try {
            $model = $this->sp_repository->with(['leads', 'students', 'employees','employees.files' ,'files'])->where('id', $id)->first();
            if (isset($model->id)) {
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
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
    }
    public function sp_upload_files($params){
        $params['title'] = "Upload File";    
        $code = "NTS" .  rand(1000, 999999);
        $url = "/assets/upload/" . $code . "/";
        $data = $this->upload_file($params, $url);           
        // $data['types'] = Files::TYPE_FILES;
        // $this->file_repository->create($data);
        return $data;
    }
    private function get_employees_id($params){
        $employees_id = null;
        if(isset($params['send_cc']) && strlen($params['send_cc']) > 0) {
            $employees_id = Employees::where('email', $params['send_cc'] )->first()->id;
        } else {
            if(!isset($params['employees_id'])) {
                $employees_id = $this->get_first_employees();
            }
        }
        return $employees_id;
    }
    public function create($params) {        
        try {                              
            DB::beginTransaction();
            if(isset($params['File'])) {
                $file = $this->sp_upload_files($params);
                $params["file_url"] = $file['image_url'];
            }                        
            $params['code'] = rand(1,999999);
            $params['employees_id'] = $this->get_employees_id($params);            
            if(isset($params["File"])) {
                $data = $this->unset_array($params, 'File');
            } else {
                $data = $params;
            }
            $model =  $this->sp_repository->create($data);           
            $result = null;
            if(isset($model->id)) {                
                $this->get_send_mail($params);
                $result = response()->json([
                    "code"      => 200,
                    "message"   => "Thêm mới yêu cầu hỗ trợ thành công",
                    "data"      => $model
                ]); 
            } else {
                $result = response()->json([
                    "code"      => 422,
                    "message"   => "Thêm mới yêu cầu hỗ trợ không thành công",                    
                ]); 
            }    
            DB::commit();     
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
        }
    }    
    public function createMultiple($params) {
        try {
            $data = [];
            foreach ($params as $item) {               
                $item['created_by'] = Auth::user()->id ?? null;
                $item['code'] = rand(1,999999);      
                $data[] = $item;
            }                 
            $model =  $this->sp_repository->createMultiple($data);
            if(count($model) > 0) {
                return response()->json([
                    "code"      => 200,
                    "message"   => "Thêm mới yêu cầu hỗ trợ thành công",
                    "data"      => $model
                ]); 
            } else {
                return response()->json([
                    "code"      => 422,
                    "message"   => "Thêm mới yêu cầu hỗ trợ không thành công",                    
                ]); 
            }
           
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
       }
    }    
    public function update($params, $id) {                     
        try {
            $model = $this->sp_repository->where('id', $id)->updateById($id, $params);
            if(isset($model->id)) {                
                return response()->json([
                    "code" => 200,
                    "message" => "Cập nhật phiếu yêu cầu thành công"
                ]);  
            } else {
                return response()->json([
                    "code" => 422,
                    "message" => "Không tìm thấy phiếu yêu cầu hỗ trợ này"
                ]);     
            }        
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
        }
    }
    public function delete($id) {
        try {
            DB::beginTransaction();
            $model = $this->sp_repository->where('id', $id)->deleteById($id);
            if($model  == true) {                
                $result = [
                    "code" => 200,
                    "message" => "Xóa phiếu yêu cầu thành công"
                ];
            } else {
                $result= [
                    "code" => 422,
                    "message" => "Xóa phiếu yêu cầu thất bại"
                ];     
            }      
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
        }
    }
    public function export($params){       
        $query = $this->filter($params);
        $data = $query->get();        
        $file_name = "danh_sach_yeu_cau_ho_tro_" . date('d-m-Y'). '.xlsx';
        return Excel::download(new SupportsExports($data),  $file_name );
    }
    private function get_send_mail($data) {        
        $params["types_id"] = EmailTemplateTypes::TYPE_SUPPORTS; //         
        $file_name  = $this->get_file_name($params, "includes.crm.mau_thong_bao_yeu_cau_ho_tro");
        if (view()->exists($file_name)) {
            $data_sendmail = [
                'title'         => $data["subject"] ?? 'Yêu cầu hỗ trợ',
                'subject'       => $data["subject"] ?? 'Yêu cầu hỗ trợ',
                'cau_hoi'       => $data["descriptions"] ?? '',
                'tra_loi'       => $data["answers"] ?? 'Tư vấn viên đã tiếp nhận câu hỏi của bạn',
                'to'            => $data["email"] ?? ($data["send_to"] ?? null),
                'email'         => $data["email"] ?? ($data["send_to"] ?? null),
            ];                      
            SendMailJobs::dispatch($data_sendmail, $file_name);
        } 
    }
    public function update_reply($params, $id){        
        try {                        
            DB::beginTransaction();
            $supports = Supports::where('id', $id)->first();             
            if(!isset($supports->id)){
                return [
                    "code"      => 422,
                    "message"   => "Không tìm thấy bản ghi này"    
                ];
            }            
            $data = $supports;
            $update = $supports->update($params);
            $results = null;
            if($update) {
                $this->get_send_mail($data);
                Log::info("Gửi thư từ Trả lời Yêu cầu hỗ trợ");
                $results = [
                    "code"      => 200,
                    "message"   => "Cập nhật thông tin thành công"
                ];
            } else {
                $results = [
                    "code"      => 422,
                    "message"   => "Cập nhật thông tin không thành công"
                ];
            }
            DB::commit();
            return $results;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
        }
    }
    public function auto_update_status_support() {        
        try {                              
            DB::beginTransaction();
            $result = null;
            $config = ConfigGeneral::where('types', ConfigGeneral::TYPES_SUPPORTS)->first()->toArray();        
            $model  = Supports::with(['employees'])->get()->toArray();           
            $dem = 0;
            foreach ($model as $item) {            
                $c_date = Carbon::now()->format('Y-m-d'); // date trong db
                $n_date = Carbon::parse($item['created_at'])->addDay($config['end_date'])->format('Y-m-d'); // date + n
                if($c_date > $n_date && strlen($item["answers"]) <= 0 && $item['sp_status_id'] != SupportsStatus::STATUS_CLOSE) {                    
                    $data = [
                        "sp_status_id"  => SupportsStatus::STATUS_CLOSE,
                        "created_by"    => Auth::user()->id ?? null,
                        "note"          => "Tự động đóng yêu cầu hỗ trợ do quá " . $config['end_date'] . " ngày so với Yêu cầu hỗ trợ được tạo",
                    ];                                
                    UpdateReplationshipJobs::dispatch('supports', ['id' => $item['id']], $data);
                    $dem += 1;
                }            
            }            
            if($dem > 0) {
                $result = [
                    "code"      => 200,
                    "message"   => "Success"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Not Success"
                ];
            }
            DB::commit();     
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json([
                "code" => 422,
                "message" => $e->getMessage()
            ]); 
        }
        
    }
}
