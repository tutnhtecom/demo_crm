<?php

namespace App\Services\Permissions;

use App\Models\Employees;
use App\Models\Permissions;
use App\Models\RolePermissions;
use App\Models\User;
use App\Models\UserRolePermissions;
use App\Repositories\PermissionsRepository;
use App\Traits\General;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PermissionsServices implements PermissionsInterface
{
    use General;
    protected $per_repository;
    public function __construct(PermissionsRepository $per_repository)
    {
        $this->per_repository = $per_repository;   
    }

    public function index($params) {        
        try {
            $model = Permissions::with(['parent', 'rPermissions', 'uRolePermissions' ])->orderBy('id', 'asc')->get()->toArray();                        
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
           return response()->json($result);
          } catch (\Exception $e) {               
               Log::error('Thông báo lỗi: ' . $e->getMessage() . ' tại dòng số: ' . $e->getMessage());
               return response()->json(['message' => $e->getMessage()]);
          }
        
    }
    public function details($id) {
       try {
         $model = $this->per_repository->where('id', $id, '=')->first();
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
            return response()->json([
                'code' => 200,
                'message' => 'Không tìm thấy bản ghi này'
            ]);
       }
       return response()->json($result);
    }
    public function get_id_by_data_all() {        
        $data = [];
        if(Auth::user()->id === User::IS_ROOT) $status = true;
        else {
            $id = Permissions::where('name', 'LIKE', '%Xem (chung)%')->get()->pluck('id')->toArray();  
            $uRolePermissions = UserRolePermissions::with(['permissions'])->where('users_id', Auth::user()->id)
                ->whereIn('permissions_id', $id)->get()->toArray();
            foreach ($uRolePermissions as $key => $value) {
                $value['router_name'] = $value['permissions']['router_name'];
                $data[] = $value;
            }       
        }        
        return $status;
    }
    public function set_permission_for_router_name($params){
        $status = false;
        if(!Auth::user())  {
            return redirect()->route('crm.login');
        }
        if (Auth::user()->id == User::IS_ROOT){
                $status = true;
        }
        $employees      = Employees::where('email', Auth::user()->email)->first();                
        $roles_id       = $employees["roles_id"];
        if(isset($params['router_web_name'])) {
            $permissions_id     = Permissions::where('router_web_name', $params['router_web_name'])->first()->id;
            $u_role_permission  = RolePermissions::where('roles_id', $roles_id)
                                ->where('permissions_id', $permissions_id)
                                ->get();          
            
            if(isset($u_role_permission->roles_id)) {
                $status = true;
            } else {
                $status = false;
            }
        }  else {
            $status = false;
        }             
        return [
            "code"      => 200,
            "status"    => $status
        ];
    }
}
