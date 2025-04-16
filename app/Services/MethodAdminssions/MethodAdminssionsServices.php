<?php

namespace App\Services\MethodAdminssions;
use App\Repositories\MethodAdminssionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MethodAdminssionsServices implements MethodAdminssionsInterface
{    
    
    protected $method_repository;
    public function __construct(MethodAdminssionRepository $method_repository)
    {
       $this->method_repository = $method_repository;   
    }
    public function index($params) {
        try {
            $model = $this->method_repository;
            if(isset($params['name'])) {               
                $model = $model->where('name','like', '%'.$params['name'].'%');
            }
            $model = $model->orderBy('id', 'desc')->get()->toArray();                        
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
               return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
          }
          return response()->json($result);
    }
    public function details($id) 
    {
       try {
         $model = $this->method_repository->where('id', $id, '=')->first();
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

    public function createMultiple($params){        
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

            $model = $this->method_repository->createMultiple($data);
            $result = null;
            if(count($model) > 0) {
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

    public function create($params) {
       try {
            $data = [
                "name" => trim($params['name']),
                "created_by" => Auth::user()->id ?? NULL
            ];   
            $model = $this->method_repository->create($data);
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
    public function update($params, $id) {
        try {
            $params['updated_by'] = Auth::user()->id ?? null;        
            $model = $this->method_repository->updateById($id, $params);
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
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
       }
    }
    public function delete($id) {
        try {
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];       
            $model = $this->method_repository->updateById($id, $data); 
            $result = null;
            if($model) {
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
            return response()->json($result);
        } catch (\Exception $e) {            
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }        
        
    }
}
