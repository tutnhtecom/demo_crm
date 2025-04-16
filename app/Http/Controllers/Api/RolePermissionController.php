<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRolePermissionRequest;
use App\Services\RolesPermissions\RolePermissionsInterface;
use App\Services\RolesPermissions\RolesPermissionsInterface;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{

    protected $rPermissions_interface;
    public function __construct(RolesPermissionsInterface $rPermissions_interface)
    {
        $this->rPermissions_interface = $rPermissions_interface;
    }
    // CreateRolePermissionRequest
    public function store(CreateRolePermissionRequest $request) {
        $params =  $request->all();
        return  $this->rPermissions_interface->store($params);
    }
}
