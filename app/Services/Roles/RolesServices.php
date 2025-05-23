<?php

namespace App\Services\Roles;

use App\Repositories\RolesRepository;
use App\Traits\General;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RolesServices implements RolesInterface
{
    use General;
    protected $role_repository;
    public function __construct(RolesRepository $role_repository)
    {
        $this->role_repository = $role_repository;   
    }
    public function index($params) {
        try {
            $model = $this->role_repository->with(['role_permissions:id,permissions_id,roles_id']);
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
    public function details($id) {
       try {
         $model = $this->role_repository->where('id', $id, '=')->first();
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
                "name" => trim($params['name']),
                "slug" => $this->slugify(trim($params['name'])),
                "created_by" => Auth::user()->id ?? NULL
            ];               
            $model = $this->role_repository->create($data);
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
            $params['slug'] = $this->slugify($params['name'] );
            $params['updated_by'] = Auth::user()->id ?? null;        
            $model = $this->role_repository->updateById($id, $params);
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
            $model = $this->role_repository->updateById($id, $data); 
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
            if(!is_array($params['name'])) {
                return false;
            }

            foreach ($params['name'] as $name) {
                $data[] = [
                    "name" => $name,
                    "slug" => $this->slugify(trim($name)),
                    "created_by" => Auth::user()->id ?? NULL
                ];
            }
            $model = $this->role_repository->createMultiple($data);
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

    public function dataPermission(){
        $permissions      = DB::table('permissions')->select(['id', 'name', 'parent_id'])->get();
        $rolesPermissions = DB::table('roles_permissions')->select(['id', 'permissions_id', 'roles_id'])->get();
        // $rolesPermissions = DB::table('permissions')
        //                     ->join('roles_permissions', 'permissions.id', '=', 'roles_permissions.permissions_id')
        //                     ->select('permissions.id', 'roles_permissions.permissions_id', 'roles_permissions.roles_id', 
        //                             'permissions.name', 'permissions.parent_id')
        //                     ->get();

        return [
            "permissions"      => $permissions,
            "rolesPermissions" => $rolesPermissions,
        ];
    }
}
