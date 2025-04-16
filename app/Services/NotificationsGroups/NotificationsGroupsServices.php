<?php

namespace App\Services\NotificationsGroups;

use App\Models\Employees;
use App\Models\Leads;
use App\Models\NotificationsGroups;
use App\Models\Students;
use App\Models\User;
use App\Repositories\NotificationsGroupsRepository;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NotificationsGroupsServices implements NotificationsGroupsInterface
{
    use General;
    protected $noti_group_repository;
    protected $user;
    protected $employees;
    protected $leads;
    protected $students;
    public function __construct(NotificationsGroupsRepository $noti_group_repository, User $user, Employees $employees, Leads $leads, Students $students)
    {
        $this->noti_group_repository = $noti_group_repository;
        $this->user                  = $user;
        $this->employees             = $employees;
        $this->leads                 = $leads;
        $this->students              = $students;
    }
    public function index($params) {
        try {
            $model = $this->noti_group_repository;
            $data = [];
            if(isset($params['name'])) {
                $model = $model->where('name','like', '%'.$params['name'].'%');
            }
            $model = $model->orderBy('id', 'desc')->get()->toArray();
            foreach ($model as $item) {
                $item['email'] =  explode(', ', json_decode($item['email']));
                $data[] = $item;
            }
            if(count($model) > 0) {
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
    public function details($id) {
        try {
            $model = NotificationsGroups::where('id', $id)->first();

            $types = null;
            if (isset($model->types)) {
                $types = $model->types;
            }
            $ids = explode(',', json_decode($model->list_id));
            $data = null;
            switch ($types) {
                case '0':
                    $email = $this->get_data_email('leads', $ids);
                    $data = Leads::whereIn('email', $email)->get()->toArray();
                    break;

                case '1':
                    $email = $this->get_data_email('students', $ids);
                    $data = Students::whereIn('email', $email)->get()->toArray();
                    break;

                case '2':
                    $email = $this->get_data_email('employees', $ids);
                    $data = Employees::whereIn('email', $email)->get()->toArray();
                    break;

                default:
                    $email = $this->get_data_email('leads', $ids);
                    $data = Leads::whereIn('email', $email)->get()->toArray();
                    break;
            }
            if (isset($model->id)) {
                $result = [
                    "code"   => 200,
                    "data"   => $model,
                    "detail" => $data
                ];
            } else {
                $result = [
                    "code" => 422,
                    "message" => "Dữ liệu thêm mới thất bại"
                ];
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function create($params) {
        try {
            DB::beginTransaction();
            $data['name']       = trim($params['name']) ?? '';
            $data['types']       = trim($params['types']) ?? '';
            $data['list_id']    = isset($params['list_id']) ? json_encode(implode(',', $params['list_id'])) : '';
            $data['created_by'] = Auth::user()->id ?? 1;
            $model = $this->noti_group_repository->create($data);
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
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return $e->getMessage();
        }
    }
    public function update($params, $id) {
        try {
            DB::beginTransaction();
            $data = [];
            if(isset($params['name'])) {
                $data['name'] = trim($params['name']);
            }
            if(isset($params['list_id'])) {
                $data['list_id'] = json_encode(implode(', ', $params['list_id']));
            }
            $data['updated_by'] = Auth::user()->id ?? 1;
            $model = $this->noti_group_repository->updateById($id, $data);
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
            DB::commit();
            return response()->json($result);
       } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()]);
       }


    }
    public function delete($id) {
        try {
            $data = [
                'deleted_at' => Carbon::now(),
                'deleted_by' => Auth::user()->id ?? null
            ];
            $model = $this->noti_group_repository->updateById($id, $data);
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
    public function createMultiple($params) {
        try {
            foreach ($params as $item) {

                $data[] = [
                    "name"       => $item['name'],
                    "list_id"    => json_encode(implode(',', $item['list_id'])),
                    "created_by" => Auth::user()->id ?? NULL
                ];
            }
            $model = $this->noti_group_repository->createMultiple($data);
            $result = null;
            if (count($model)) {
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
    public function getDataGroups(){
        $dataGroup = $this->noti_group_repository->get();

        return $dataGroup;
    }

    public function getUserEmail(){
        // $userData = $this->user->get();
        // $userData = $this->user->select('email')->get();
        $employees = $this->employees->select('id','name','email')->get();
        $leads     = $this->leads->select('id','full_name','email')->get();
        $students     = $this->students->select('id','full_name','email')->get();
        return [
            'employees' => $employees,
            'leads' => $leads,
            'students' => $students,
        ];
    }
}
