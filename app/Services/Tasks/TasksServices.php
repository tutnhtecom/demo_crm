<?php

namespace App\Services\Tasks;

use App\Jobs\CreateNotificationsJobs;
use App\Models\Employees;
use App\Models\Notifications;
use App\Models\Tasks;
use App\Repositories\TasksRepository;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TasksServices implements TasksInterface
{
    use Information;
    protected $task_repository;
    public function __construct(TasksRepository $task_repository)
    {
        $this->task_repository = $task_repository;
    }
    private function filter($params){
        $model = Tasks::with(["employees.roles", "employees.files"]);
        if (isset($params['employees_id'])) {
            $model = $model->where('employees_id', $params['employees_id']);
        }
        if (isset($params['sort'])) {
            $model = $model->orderBy('id', $params['sort']);
        } else {
            $model = $model->orderBy('id', 'desc');
        }
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
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json(['code' => 422, 'message' => $e->getMessage()]);
        }

    }
    public function details($id) {
       try {
         $model = $this->task_repository->where('id', $id, '=')->first();
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
            $params["from_date"] =  isset($params["from_date"]) ?  Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y-m-d') : null;
            $params["to_date"] =  isset($params["to_date"]) ?  Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y-m-d') : null;
            $params["created_by"] = Auth::user()->id ?? NULL;
            $params["status"] = Tasks::STATUS_NOT_PROCESSING ?? 0;
            $model = $this->task_repository->with(['employees'])->create($params);
            $result = null;
            if(isset($model->id)) {
                $fromDate = $model['from_date'] ? Carbon::createFromFormat('Y-m-d', $model['from_date'])->format('d/m/Y') : 'Không xác định';
                $toDate = $model['to_date'] ? Carbon::createFromFormat('Y-m-d', $model['to_date'])->format('d/m/Y') : 'Không xác định';

                $title = "Bạn có vừa nhận được task công việc có tên là: " . $model->name;
                $content = "Ngày bắt đầu: " . $fromDate
                            . " - Ngày kết thúc: " . $toDate
                            . " - Link công việc: <a href='" . url('/') . "/crm/task_management/list' class='btn btn-primary' target='_blank'>Xem chi tiết</a>";

                $this->create_notification($model, $content, $title);
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
    public function update($params, $id) {
        try {
            $params['updated_by'] = Auth::user()->id ?? null;
            $params["from_date"] =  isset($params["from_date"]) ?  Carbon::createFromFormat('d/m/Y', trim($params["from_date"]))->format('Y-m-d') : null;
            $params["to_date"] =  isset($params["to_date"]) ?  Carbon::createFromFormat('d/m/Y', trim($params["to_date"]))->format('Y-m-d') : null;
            $model = $this->task_repository->updateById($id, $params);
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
            return response()->json(['message' => 'Không tìm thấy bản ghi này']);
       }
    }
    public function delete($id) {
        try {
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->task_repository->updateById($id, $data);
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

    public function update_status($params, $id){
        try {
            $model = $this->task_repository->updateById($id, $params);
            $result = null;
            if (isset($model->id)) {
                $result = [
                    "code" => 200,
                    "message" => "Trạng thái đã được cập nhật thành công"
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Trạng thái đã được cập nhật không thành công"
                ];
            }
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return response()->json(['code' => 422, 'message' => $e->getMessage()]);
        }
    }

    public function getEmployees(){
        $employees = Employees::select(['id', 'name', 'code'])->get();
        return $employees;
    }
}
