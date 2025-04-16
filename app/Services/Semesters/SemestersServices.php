<?php

namespace App\Services\Semesters;

use App\Models\AcademicTerms;
use App\Models\ConfigSemesters;
use App\Models\Semesters;
use App\Repositories\AcademicTermsRepository;
use App\Repositories\ConfigSemestersRepository;
use App\Repositories\MarjorsRepository;
use App\Repositories\SemestersRepository;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SemestersServices implements SemestersInterface
{
    use General;
    protected $semesters_repository;
    protected $academic_terms_repository;
    protected $config_semesters_repository;
    public function __construct(
        SemestersRepository $semesters_repository,
        AcademicTermsRepository $academic_terms_repository,
        ConfigSemestersRepository $config_semesters_repository
    )
    {
       $this->semesters_repository = $semesters_repository;
       $this->academic_terms_repository = $academic_terms_repository;
       $this->config_semesters_repository = $config_semesters_repository;
    }
    public function index($params)
    {
        try {
            $model = $this->semesters_repository;
            if (isset($params['name'])) {
                $model = $model->where('name', 'like', '%' . $params['name'] . '%');
            }
            if (isset($params['academic_terms_id'])) {
                $model = $model->where('academic_terms_id', $params['academic_terms_id']);
            }
            $model = $model->orderBy('id', 'desc')->get()->toArray();
            $data = [];
            foreach ($model as $item) {
                $data[] = [
                    "id"    => $item['id'] ?? null,
                    "name"          => $item['name'] ?? null,
                    "from_date"     => $item['from_day'] .'/'. $item['from_month'] .'/'. $item['from_year'],
                    "to_date"     => $item['to_day'] .'/'. $item['to_month'] .'/'. $item['to_year'],
                ];
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
            return response()->json(['message' => 'Hệ thống chưa có bản ghi nào'], 404);
        }
        return response()->json($result);
    }
    public function details($id){
       try {
           $model = Semesters::where('id', $id, '=')->first();
         if(isset($model->id)) {
            $data = [
                "name"          => $model['name'] ?? null,
                "from_date"     => $model['from_day'] .'/'. $model['from_month'] .'/'. $model['from_year'],
                "to_date"     => $model['to_day'] .'/'. $model['to_month'] .'/'. $model['to_year'],
            ];
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
            return response()->json(['message' => $e->getMessage()], 404);
       }
       return response()->json($result);
    }
    public function createMultiple($params){
        try {
            DB::beginTransaction();
            if(!isset($params['academic_terms_name'])) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn niên khóa cho học kỳ"
                ];
            }
            $condition = [ "name" => $params['academic_terms_name']];
            $academic_terms_id = $this->get_data_by_output('academic_terms', $condition, 'id');
            if(!isset($academic_terms_id)) {
                return [
                    "code" => 422,
                    "message" => "Không tìm thấy niên khóa: " . $params['academic_terms_name'] . " trên hệ thống"
                ];
            }
            foreach ($params['data'] as $item) {
                if(strlen($item['name']) > 0) {
                    $data[] = [
                        "name"              => isset($item['name']) ? trim($item['name']) : '',
                        "from_day"          => isset($item["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["from_date"]))->format('d') : null,
                        "from_month"        => isset($item["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["from_date"]))->format('m') : null,
                        "from_year"         => isset($item["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["from_date"]))->format('Y') : null,
                        "to_day"            => isset($item["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["to_date"]))->format('d') : null,
                        "to_month"          => isset($item["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["to_date"]))->format('m') : null,
                        "to_year"           => isset($item["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($item["to_date"]))->format('Y') : null,
                        "academic_terms_id" => $academic_terms_id,
                        "created_by"        => Auth::user()->id ?? 1
                    ];
                }
            }
            $model = $this->semesters_repository->createMultiple($data);
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
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }
    }
    public function create($params) {
       try {
            DB::beginTransaction();
            if(!isset($params['academic_terms_name'])) {
                return [
                    "code" => 422,
                    "message" => "Vui lòng chọn niên khóa cho học kỳ"
                ];
            }
            $condition = [ "name" => $params['academic_terms_name']];
            $academic_terms_id = $this->get_data_by_output('academic_terms', $condition, 'id');
            if(!isset($academic_terms_id)) {
                return [
                    "code" => 422,
                    "message" => "Không tìm thấy niên khóa: " . $params['academic_terms_name'] . " trên hệ thống"
                ];
            }
            $data = [
                "name"              => isset($params['name']) ? trim($params['name']) : '',
                "from_day"          => isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('d') : null,
                "from_month"        => isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('m') : null,
                "from_year"         => isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y') : null,
                "to_day"            => isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('d') : null,
                "to_month"          => isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('m') : null,
                "to_year"           => isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y') : null,
                "academic_terms_id" => $academic_terms_id,
                "created_by"        => Auth::user()->id ?? 1
            ];
            $model = $this->semesters_repository->create($data);
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
            DB::commit();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
       }
    }
    public function update($params, $id) {
        try {
            // Thời gian bắt đầu
            if(isset($params["from_date"])) {
                $params["from_day"]     = isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('d') : null;
                $params["from_month"]   = isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('m') : null;
                $params["from_year"]    = isset($params["from_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y') : null;
            }
            // Thời gian kết thúc
            if(isset($params["from_date"])) {
                $params["to_day"]     = isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('d') : null;
                $params["to_month"]   = isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('m') : null;
                $params["to_year"]    = isset($params["to_date"]) ? Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y') : null;
            }

            $params["updated_by"]     = Auth::user()->id ?? 1;
            $model = $this->semesters_repository->updateById($id, $params);
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
            $model = $this->semesters_repository->updateById($id, $data);
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
    public function data_config(){
        $model = $this->config_semesters_repository->get()->toArray();
        return $model;
    }

    public function update_semesters_config($params, $id){
        try {
            DB::beginTransaction();
            $model = ConfigSemesters::where('id', $id)->first();
            if(!isset($model->id)) {
                return [
                    "code"      => 200,
                    "message"   => "Vui lòng chọn bản ghi cần cập nhật"
                ];
            }
            $update = $model->update($params);
            $result = null;
            if($update == true){
                $result = [
                    "code"      => 200,
                    "message"   => "Cập nhật thông tin thành công"
                ];
            } else {
                $result = [
                    "code"      => 422,
                    "message"   => "Cập nhật thông tin không thành công"
                ];
            }
            DB::commit();
            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => 'Không tìm thấy bản ghi này'], 404);
        }
    }
}
