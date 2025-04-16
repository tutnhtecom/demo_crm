<?php

namespace App\Services\ConfigGeneral;

use App\Models\ConfigGeneral;
use App\Models\Leads;
use App\Models\LstStatus;
use App\Repositories\ConfigGeneralRepository;
use App\Services\ConfigGeneral\ConfigGeneralsInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigGeneralServices implements ConfigGeneralsInterface
{    
    protected $config_general_repository;
    public function __construct(ConfigGeneralRepository $config_general_repository)
    {
        $this->config_general_repository = $config_general_repository;   
    }
    private function filter($params){
        $model = $this->config_general_repository;
        if (isset($params['keyword'])) {
            $model = $model->where('name', 'LIKE', '%' . $params['keyword'] . '%' );
        }
        
        if (isset($params['sort']) && in_array($params['sort'], ['desc', 'asc'])) {
            $model = $model->orderBy('id', $params['sort']);
        } else {
            $model = $model->orderBy('id', 'desc');
        }        
        return $model;
    }
    public function index($params)
    {
        try {
            $model = $this->filter($params)->get()->toArray();            
            $data =[];
            foreach ($model as $item) {                                
                $data[ConfigGeneral::TYPES_MAP_TEXT[$item["types"]]] = $item;
            }                        
            if (count($model) > 0) {
                $result = [
                    "code" => 200,
                    "data" => $data
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Hệ thống chưa có bản ghi nào"
                ];
            }
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 404);
        }
        return response()->json($result);
    }
    public function details($id) {
       try {
         $model = $this->config_general_repository->where('id', $id, '=')->first();
         $data[ConfigGeneral::TYPES_MAP_TEXT[$model["types"]]] = $model->toArray();         
         if(isset($model->id)) {
            $result = [
                "code" => 200,                
                "data" => $data
            ]; 
        } else {
            $result = [
                "code" => 422,
                "message" => "Dữ liệu thêm mới thất bại"
            ]; 
        }
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }
       return response()->json($result);
    }
    public function create($params) {
       try {                   
            if($params["types"] == ConfigGeneral::TYPES_KPIS)       $params["title"] = "Thiết lập cấu hình cho KPI";
            if($params["types"] == ConfigGeneral::TYPES_TASK)       $params["title"] = "Thiết lập cấu hình cho TASK";
            if($params["types"] == ConfigGeneral::TYPES_SUPPORTS)   $params["title"] = "Thiết lập cấu hình cho Yêu cầu hỗ trợ";            
            $dem = $this->config_general_repository->where('types', $params["types"])->count();            
            if($dem > 0) {
                return [
                    "code" => 422,
                    "message" => $params["title"] . " đã có! Vui lòng chọn thiết lập khác"
                ]; 
            }            
            $model = $this->config_general_repository->create($params);
            $result = null;
            if(isset($model->id)) {
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
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }
    }
    
    public function update($params, $id)
    {        
        try {
            DB::beginTransaction();
            if(!isset($id)) {           
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi",
                ];
            }    
            $params['updated_by'] = Auth::user()->id ?? null;
            $model = $this->config_general_repository->updateById($id, $params);
            $result = null;
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được cập nhật thành công"
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
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }    
    public function delete($id) {
        try {
            DB::beginTransaction();
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];               
            $model = $this->config_general_repository->updateById($id, $data); 
            $result = null;
            if($model) {
                $result = [
                    "code" => 200,
                    "message" => "Dữ liệu đã được xóa thành công"
                ]; 
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu xóa bỏ không thành công"
                ]; 
            }
            DB::commit();
            return response()->json($result);
        } catch (\Exception $e) {            
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Dữ liệu xóa bỏ không thành công'], 404);
        }        
        
    }
}
