<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\AcademyList;
use App\Models\DVLKSemesters;
use App\Models\EmailTemplates;
use App\Models\EmailTemplateTypes;
use App\Models\LineVoip;
use App\Services\Employees\EmployeesInterface;
use App\Services\Tasks\TasksInterface;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EmployeesController extends Controller
{
    use General, Information;
    protected $employee_interface;
    protected $task_interface;
    public function __construct(EmployeesInterface $employee_interface, TasksInterface $task_interface)
    {
        $this->employee_interface = $employee_interface;
        $this->task_interface = $task_interface;
    }
    public function employeesList(Request $request){
        $param = $request->all();
        $dataResponse = $this->employee_interface->index($param);       
        $dvlk_semesters = $this->get_data_dvlk_semesters($param);  
        $data = $dataResponse->getData(true);        
        $dataEmployeeDB = DB::table('employees')->get();     
        $academy_list = AcademyList::select('id', 'name')->get();  
        return view('crm.content.employees.employees_list', ['data' => $data, 'dataDB' => $dataEmployeeDB, 'dvlk_semesters' => $dvlk_semesters, "academy_list" => $academy_list]);
    }

    public function createEmployees(){
        $email_template = $this->get_data_email_template();               
        $dataRole = $this->employee_interface->dataRole();
        $line_id_voip = LineVoip::select(['line_id', 'line_password'])->whereNull('deleted_at')->get();
        return view('crm.content.employees.employees_create', compact('dataRole', 'email_template', 'line_id_voip'));
    }
    private function get_data_email_template_1(){
        $email_template  = EmailTemplates::whereHas('eTemplateTypes', function ($q) {
            $q->where('types_id', EmailTemplateTypes::TYPE_EMPLOYEES);                
        })->get()->toArray();                             
        return $email_template;
    }
    private function get_data_email_template(){
        $e_template  = EmailTemplates::whereHas('eTemplateTypes', function ($q) {
            $q->where('types_id', EmailTemplateTypes::TYPE_EMPLOYEES);                
        })->get()->toArray();                        
        $email_template = [];
        foreach ($e_template as $key => $item) {
            if(view()->exists('includes.template.' . $item["file_name"])) {
                $email_template[] = $item;
            }
        }        
        return $email_template;
    }
    public function detailEmployees($id){
        $dataId = $this->employee_interface->details($id);
        // Hiển thị danh sách công việc
        $task_params = array();
        $task_params['employees_id'] = $id;
        $tasks =  $this->task_interface->index($task_params);
        // $tasks_data = $tasks->getData()->data;


        if(!is_array($dataId) || $dataId['code'] !== 200){
            $msg = "ID không tồn tại.";
            return view('errors.404', ['msg' => $msg]);
        }
        $imageEmployee = null;
        if(isset($dataId['data']) && count($dataId['data']->files) > 0) {
            foreach ($dataId['data']->files as $file) {
                if ($file['types'] === 0 && isset($file)) {
                    $imageEmployee = $file['image_url'];
                }
            }
        }
        $status = $this->employee_interface->dataStatus();

        return view('crm.content.employees.employees_detail', compact('dataId', 'imageEmployee', 'status', 'tasks'));
    }

    public function editEmployees($id){
        $dataId = $this->employee_interface->details($id);
        $dataRole = $this->employee_interface->dataRole();
        $imageEmployee = null;
        foreach ($dataId['data']->files as $file) {
            if ($file['types'] === 0 && isset($file)) {
                $imageEmployee = $file['image_url'];
            }
        }
        $line_id_voip = LineVoip::select(['line_id', 'line_password'])->whereNull('deleted_at')->get();
        return view('crm.content.employees.employees_edit', compact('dataId', 'dataRole', 'imageEmployee','line_id_voip'));
    }
}
