<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\Roles\RolesInterface;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    protected $role_interface;
    public function __construct(RolesInterface $role_interface)
    {
        $this->role_interface = $role_interface;
    }

    public function roleDetail(Request $request){
        $dataResponse = $this->role_interface->index($request);
        $data = $dataResponse->getData(true);
        $dataPermission = $this->role_interface->dataPermission();        
        return view('crm.content.rolePermission.role_permissions', compact('data', 'dataPermission'));
    }
}
