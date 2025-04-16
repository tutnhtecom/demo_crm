<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEmployeesRequest;
use App\Http\Requests\FilesRequest;
use App\Http\Requests\UpdateEmployeesRequest;
use App\Services\Employees\EmployeesInterface;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employees_interface;
    public function __construct(EmployeesInterface $employees_interface)
    {
        $this->employees_interface = $employees_interface;
    }

    public function index(Request $request){
        $params =  $request->all();
        return  $this->employees_interface->index($params);
    }
    public function details($id) {
        return $this->employees_interface->details($id);
    }

    public function get_all_leads(Request $request){
        $params =  $request->all();
        return  [
            "code" => 200,
            "data" => $this->employees_interface->details($params)['data']['leads'],
        ];
    }
    public function create(CreateEmployeesRequest $request) {
        $params =  $request->all();
        return  $this->employees_interface->create($params);
    }

    public function update(UpdateEmployeesRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->employees_interface->update($params, $id);
    }
    public function delete($id) {
        return  $this->employees_interface->delete($id);
    }

    public function imports(FilesRequest $request){
        $params = $request->all();
        return $this->employees_interface->imports($params);
    }
    public function exports(Request $request){
        $params = $request->all();
        return $this->employees_interface->exports($params);
    }
    public function not_active($id){
        return $this->employees_interface->change_status($id);
    }
    public function delete_multiple(Request $request) {
        $params = $request->all();
        return  $this->employees_interface->delete_multiple($params);
    }
    public function active_system(Request $request) {
        $params = $request->all();
        return  $this->employees_interface->active_system($params);
    }
}
