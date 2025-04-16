<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNationsRequest;
use App\Http\Requests\UpdateNationsRequest;
use App\Services\Nations\NationsInterface;
use Illuminate\Http\Request;

class NationsController extends Controller
{
    protected $nations_interface;
    public function __construct(NationsInterface $nations_interface)
    {
        $this->nations_interface = $nations_interface;
    }

    public function index(Request $request){
        $params =  $request->all();  
        return  $this->nations_interface->index($params);     
    }
    public function details($id) {
        return $this->nations_interface->details($id);
    }
    public function create(CreateNationsRequest $request) {
        $params =  $request->all();
        return  $this->nations_interface->create($params);  
    }
    public function createMultiple(Request $request) {
        $params =  $request->all();
        return  $this->nations_interface->createMultiple($params);  
    }
    public function update(UpdateNationsRequest $request, $id) {
        if(!isset($id)) {           
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }                
        $params = $request->all();                    
        return  $this->nations_interface->update($params, $id);  
    }
    public function delete($id) {        
        return  $this->nations_interface->delete($id);  
    }
}
