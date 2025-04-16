<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateApiListRequest;
use App\Http\Requests\UpdateApiListRequest;
use App\Services\ApiLists\ApiListsInterface;
use Illuminate\Http\Request;

class ApiListsController extends Controller
{
    protected $api_lists_interface;
    public function __construct(ApiListsInterface $api_lists_interface)
    {
        $this->api_lists_interface = $api_lists_interface;
    }
    public function create(CreateApiListRequest $request){
        $params = $request->all();
        return $this->api_lists_interface->create($params);
    }
    public function index(Request $request){
        $params = $request->all();
        return $this->api_lists_interface->index($params);
    }
    public function details($id){
        return $this->api_lists_interface->details($id);
    }  
    public function update(UpdateApiListRequest $request, $id){        
        $params = $request->all();
        return $this->api_lists_interface->update($params, $id);
    }
    public function delete($id){
        return $this->api_lists_interface->delete($id);
    }

    public function imports(Request $request){
        $params = $request->all();
        return $this->api_lists_interface->import($params);
    }
}
