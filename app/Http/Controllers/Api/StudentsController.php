<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConvertStudentRequest;
use App\Http\Requests\CreateLeadsRequest;
use App\Http\Requests\CreateStudentsRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Requests\UpdateStatusLeadRequest;
use App\Http\Requests\UpdateStudentsRequest;
use App\Http\Requests\UpdateStudentStatusRequest;
use App\Services\Students\StudentsInterface;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    protected $st_interface;
    public function __construct(StudentsInterface $st_interface)
    {
        $this->st_interface = $st_interface;
    }
    public function convert(CreateStudentsRequest $request){
        $params = $request->all();
        return $this->st_interface->convert($params);
    }

    public function update(UpdateStudentsRequest $request, $id){
        $params = $request->all();
        return $this->st_interface->update($params,$id);
    }

    public function data(Request $request){
        $params = $request->all();
        return $this->st_interface->data($params);
    }
    public function details($id){
        return $this->st_interface->details($id);
    }
    // public function delete($id){
    //     return $this->st_interface->delete($id);
    // }
    public function import(Request $request){
        $params = $request->all();
        return $this->st_interface->import($params);
    }
    public function export(Request $request){
        $params = $request->all();
        return $this->st_interface->export($params);
    }
    public function convert_to_leads($id){
        return $this->st_interface->convert_to_leads($id);
    }
    public function convert_multiple(ConvertStudentRequest $request){
        $params = $request->all();
        return $this->st_interface->convert_multiple($params);
    }
    public function update_multiple_academic_terms(Request $request){
        $params = $request->all();
        return $this->st_interface->update_multiple_academic_terms($params);
    }
    public function update_status_students(UpdateStatusLeadRequest $request, $id){
        $params = $request->all();
        return $this->st_interface->update_status_students($params,$id);
    }
    // ------------------------------------------------------------------------------------
    public function convert_multiple_students_to_leads(Request $request) {
        $params = $request->all();
        return $this->st_interface->convert_multiple_students_to_leads($params);
    }
}
