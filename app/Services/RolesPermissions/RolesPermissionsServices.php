<?php

namespace App\Services\RolesPermissions;

use App\Models\Roles;
use App\Repositories\RolePermissionRepository;
use App\Traits\General;
use Illuminate\Support\Facades\Log;

class RolesPermissionsServices implements RolesPermissionsInterface
{
    use General;
    protected $rPer_repository;
    public function __construct(RolePermissionRepository $rPer_repository)
    {
        $this->rPer_repository = $rPer_repository;
    }
    private function check_role_permission($roles_id)
    {
        $status = false;
        $dem = $this->rPer_repository->where('roles_id', $roles_id)->count();
        if ($dem > 0) $status = true;
        return $status;
    }
    public function store($params)
    {
        try {
            $result = null;
            if (isset($params['permissions_id']) && is_array($params['permissions_id']) && count($params['permissions_id']) > 0) {
                $check = $this->check_role_permission($params['roles_id']);
                if ($check) {
                    $this->rPer_repository->where('roles_id', $params['roles_id'])->delete();
                }
                $data = [];
                foreach ($params['permissions_id'] as $item) {
                    $data[] = [
                        "roles_id" => $params['roles_id'],
                        "permissions_id" => $item,
                    ];
                }
                $model = $this->rPer_repository->createMultiple($data);
                if (count($model) > 0) {
                    $result = [
                        "code"       => 200,
                        "message"    => "Gán quyền cho vai trò thành công"
                    ];
                } else {
                    $result = [
                        "code"       => 422,
                        "message"    => "Gán quyền cho vai trò không thành công"
                    ];
                }
            }
            return $result;
        } catch (\Exception $e) {
            Log::error('Thông báo lỗi: ' . $e->getMessage());
            return [
                "code" => 422,
                "message" => $e->getMessage()
            ];
        }
    }
}
