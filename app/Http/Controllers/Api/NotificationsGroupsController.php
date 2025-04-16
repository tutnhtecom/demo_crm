<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNotificationsGroupsRequest;
use App\Http\Requests\UpdateNotificationsGroupsRequest;
use App\Services\NotificationsGroups\NotificationsGroupsInterface;
use Illuminate\Http\Request;

class NotificationsGroupsController extends Controller
{
    protected $noti_group_interface;
    public function __construct(NotificationsGroupsInterface $noti_group_interface)
    {
        $this->noti_group_interface = $noti_group_interface;
    }
    public function index(Request $request){
        $params =  $request->all();  
        return  $this->noti_group_interface->index($params);     
    }
    public function details($id) {        
        return $this->noti_group_interface->details($id);
    }
    public function create(CreateNotificationsGroupsRequest $request) {
        $params =  $request->all();
        return  $this->noti_group_interface->create($params);  
    }
    public function createMultiple(Request $request) {
        $params =  $request->all();
        return  $this->noti_group_interface->createMultiple($params);  
    }
    public function update(UpdateNotificationsGroupsRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->noti_group_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->noti_group_interface->delete($id); 
    }
}
