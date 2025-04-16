<?php

namespace App\Services\Status;

use App\Models\Leads;
use App\Models\LstStatus;
use App\Repositories\StatusRepository;
use App\Services\Status\StatusInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StatusServices implements StatusInterface
{
    
    protected $status_repository;
    public function __construct(StatusRepository $status_repository)
    {
        $this->status_repository = $status_repository;   
    }
    private function filter($params){
        $model = LstStatus::with(["leads","students"]);
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
    public function index($params) {
        try {
            $model = $this->filter($params)->get()->toArray();
            if(count($model) > 0) {
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
          return response()->json($result);
    }
    public function details($id) {
       try {
         $model = $this->status_repository->where('id', $id, '=')->first();
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
            $data = [
                "border_color"      => trim($params['border_color']) ?? NULL,
                "bg_color"          => trim($params['bg_color']) ?? NULL,
                "color"             => trim($params['color']) ?? NULL,
                "name"              => trim($params['name']) ?? NULL,
                "created_by"        => Auth::user()->id ?? NULL
            ];             
            $model = $this->status_repository->create($data);
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
            return response()->json($result);
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }
    }
    public function createMultiple($params) {
        try {
            if(!is_array($params['name'])) {
                return false;
            }
            foreach ($params['name'] as $name) {
                $data[] = [
                    "name" => $name,
                    "created_by" => Auth::user()->id ?? NULL
                ];
            }
            $model = $this->status_repository->createMultiple($data);
            $result = null;
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
     }
    public function update($params, $id) {
        try {
            $params['updated_by'] = Auth::user()->id ?? null;              
            $model = $this->status_repository->updateById($id, $params);
            $result = null;
            if(isset($model->id)) {
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
            return response()->json($result);
       } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 404);
       }
    }
    private function check_status_delete($id){
        $status = false;
        $dem = Leads::where('lst_status_id', $id)->count();
        if($dem > 0) $status = true;
        return $status;
    }
    public function delete($id) {
        try {
            $status = $this->check_status_delete($id);
            if($status){
                return [
                    "code" => 422,
                    "message" => "Trạng thái không thể xóa! Trạng thái này đang được sử dụng cho nhiều sinh viên"
                ]; 
            }
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];               
            $model = $this->status_repository->updateById($id, $data); 
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
            return response()->json($result);
        } catch (\Exception $e) {            
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Dữ liệu xóa bỏ không thành công'], 404);
        }        
        
    }
}
