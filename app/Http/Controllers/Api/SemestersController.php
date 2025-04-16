<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMultipleSemestersRequest;
use App\Http\Requests\CreateSemestersRequest;
use App\Http\Requests\UpdateSemestersRequest;
use App\Services\Semesters\SemestersInterface;
use Illuminate\Http\Request;

class SemestersController extends Controller
{
    protected $semesters_interface;
    public function __construct(SemestersInterface $semesters_interface)
    {
        $this->semesters_interface = $semesters_interface;
    }

    public function index(Request $request){
        $params =  $request->all();
        return  $this->semesters_interface->index($params);
    }
    public function details($id) {
        return $this->semesters_interface->details($id);
    }
    public function create(CreateSemestersRequest $request) {
        $params =  $request->all();
        return  $this->semesters_interface->create($params);
    }
    public function createMultiple(CreateMultipleSemestersRequest $request) {
        $params =  $request->all();
        return  $this->semesters_interface->createMultiple($params);
    }

    public function update(UpdateSemestersRequest $request, $id) {
        if(!isset($id)) {
            return [
                "code" => 422,
                "message" => "Vui lòng chọn bản ghi",
            ];
        }
        $params = $request->all();
        return  $this->semesters_interface->update($params, $id);
    }
    public function delete($id) {
        return  $this->semesters_interface->delete($id);
    }

    public function semesters_config() {
        return  $this->semesters_interface->data_config();
    }
    public function update_semesters_config(Request $request, $id) {
        $params = $request->all();
        return  $this->semesters_interface->update_semesters_config($params, $id);
    }
}
