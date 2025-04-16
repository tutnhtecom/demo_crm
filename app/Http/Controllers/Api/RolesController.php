<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRolesRequest;
use App\Http\Requests\UpdateRolesRequest;
use App\Services\Roles\RolesInterface;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    protected $role_interface;
    public function __construct(RolesInterface $role_interface)
    {
        $this->role_interface = $role_interface;
    }
    public function index(Request $request){
        $params =  $request->all();  
        return  $this->role_interface->index($params);     
    }
    public function details($id) {
        return $this->role_interface->details($id);
    }
    public function create(CreateRolesRequest $request) {
        $params =  $request->all();
        return  $this->role_interface->create($params);  
    }
    public function createMultiple(Request $request) {
        $params =  $request->all();
        return  $this->role_interface->createMultiple($params);  
    }
    public function update(UpdateRolesRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->role_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->role_interface->delete($id);  
    }
}
