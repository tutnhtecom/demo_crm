<?php

namespace App\Services\ConfigFilters;

use App\Models\ConfigFilter;
use App\Models\ConfigGeneral;
use App\Repositories\ConfigFiltersRepository;
use App\Repositories\ConfigGeneralRepository;
use App\Repositories\ConfigVoipRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ConfigFilterServices implements ConfigFilterInterface
{    
    protected $config_filters_repository;
    protected $config_voip_repository;
    public function __construct(
        ConfigFiltersRepository $config_filters_repository,
        ConfigVoipRepository $config_voip_repository
    )
    {
        $this->config_filters_repository = $config_filters_repository;   
        $this->config_voip_repository = $config_voip_repository;
    }
    private function filter($params){
        $model = $this->config_filters_repository;
        if (isset($params['keyword'])) {
            $model = $model->where('name', 'LIKE', '%' . $params['keyword'] . '%' );
        }        
        $model = $model->orderBy('id', 'desc');
        return $model;
    }
    public function index($params)
    {
        try {
            $model = $this->filter($params)->get()->toArray();                        
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
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 404);
        }
        return $result;
    }
    public function details($id) {
       try {
         $model = $this->config_filters_repository->where('id', $id, '=')->first();
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
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }
       return response()->json($result);
    }
    public function create($params) {        
       try {
            DB::beginTransaction();            
            $params["start_date"]   = Carbon::createFromFormat('d/m/Y', trim($params["start_date"]))->format('Y-m-d');
            $params["end_date"]     = Carbon::createFromFormat('d/m/Y', trim($params["end_date"]))->format('Y-m-d');            
            $model = $this->config_filters_repository->create($params);
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
            dd($e->getMessage());
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }
    }    
    public function update($params, $id){        
        try {
            DB::beginTransaction();
            if(!isset($id)) {           
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi",
                ];
            }   
            $params["start_date"]   = Carbon::createFromFormat('d/m/Y', trim($params["start_date"]))->format('Y-m-d');
            $params["end_date"]     = Carbon::createFromFormat('d/m/Y', trim($params["end_date"]))->format('Y-m-d');      
            $params['updated_by'] = Auth::user()->id ?? null;
            $model = $this->config_filters_repository->updateById($id, $params);
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
            $model = $this->config_filters_repository->updateById($id, $data); 
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

    public function create_config_voip($params){
        $params["created_by"]   = Auth::user()->id ?? 1;
        $model = $this->config_voip_repository->create($params);
        $result = null;
        if(isset($model->id)) {
            $result = [
                "code"      => 200,
                "message"   => "Tạo cấu hình voip thành công"
            ];
        } else {
            $result = [
                "code"      => 422,
                "message"   => "Tạo cấu hình voip thành công"
            ];
        }
        return $result;
    }

    public function update_config_voip($params, $id){
        $params["updated_by"]   = Auth::user()->id ?? 1;
        $model = $this->config_voip_repository->updateById($id, $params);
        $result = null;
        if(isset($model->id)) {
            $result = [
                "code"      => 200,
                "message"   => "Cập nhật cấu hình voip thành công"
            ];
        } else {
            $result = [
                "code"      => 422,
                "message"   => "Cập nhật cấu hình voip thành công"
            ];
        }
        return $result;
    }
}
