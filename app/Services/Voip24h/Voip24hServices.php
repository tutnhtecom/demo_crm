<?php

namespace App\Services\Voip24h;

use App\Repositories\Voip24hRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Voip24hServices implements Voip24hInterface
{
    protected $voip24h_repository;
    public function __construct(Voip24hRepository $voip24h_repository)
    {
        $this->voip24h_repository = $voip24h_repository;
    }

    private function filter($params){
        $model = $this->voip24h_repository;
        if (isset($params['keyword'])) {
            $model = $model->where('name', 'LIKE', '%' . $params['keyword'] . '%' );
        }        
        $model = $model->orderBy('id', 'desc');
        return $model;
    }

    public function index($params) {
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
    public function details($id) {}
    public function create($params)
    {
        try {
            DB::beginTransaction();
            $model = $this->voip24h_repository->create($params);
            $result = null;
            if (isset($model->id)) {
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
    public function update($params, $id) {
        try {
            DB::beginTransaction();
            if(!isset($id)) {           
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn bản ghi",
                ];
            }   
            $params['updated_by'] = Auth::user()->id ?? null;
            $model = $this->voip24h_repository->updateById($id, $params);
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
            $model = $this->voip24h_repository->updateById($id, $data); 
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
