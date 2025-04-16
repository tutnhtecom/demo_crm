<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTasksRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Http\Requests\UpdateTasksRequest;
use App\Http\Requests\UpdateTasksStatusRequest;
use App\Services\Tasks\TasksInterface;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    protected $task_interface;
    public function __construct(TasksInterface $task_interface)
    {
        $this->task_interface = $task_interface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->task_interface->index($params);     
    }
    public function details($id) {
        return $this->task_interface->details($id);
    }
    public function create(CreateTasksRequest $request) {
        $params =  $request->all();
        return  $this->task_interface->create($params);  
    }
   
    public function update(UpdateTasksRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->task_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->task_interface->delete($id);  
    }
    public function update_status(UpdateTasksStatusRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();        
        return  $this->task_interface->update_status($params, $id);  
    }
}
