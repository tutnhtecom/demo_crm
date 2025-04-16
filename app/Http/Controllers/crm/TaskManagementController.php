<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Models\DVLKSemesters;
use App\Models\Kpis;
use App\Models\KpisStatus;
use App\Models\Tasks;
use App\Services\Employees\EmployeesInterface;
use App\Services\Kpis\KpisInterface;
use App\Services\Tasks\TasksInterface;
use App\Traits\General;
use App\Traits\Information;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskManagementController extends Controller
{
    use General, Information;
    protected $task_interface;
    protected $employees_interface;
    protected $kpis_interface;
    public function __construct(TasksInterface $task_interface, EmployeesInterface $employees_interface, KpisInterface $kpis_interface)
    {
        $this->task_interface = $task_interface;
        $this->employees_interface = $employees_interface;
        $this->kpis_interface = $kpis_interface;
    }

    public function listTask(Request $request)
    {        
        $response = $this->task_interface->index($request);
        $data = $response->getData();
        $employees = $this->task_interface->getEmployees();
        return view('crm.content.taskManagement.task_list', compact('data', 'employees'));
    }

    public function targetTask(Request $request)
    {        
        $params = $request->all();
        // $response = $this->employees_interface->index($params);
        $response = $this->employees_interface->index($request);        
        $data = $response->getData();                 
        $kpiStatus = KpisStatus::first()->status ?? null;
        $to_day = Carbon::now()->format('Y-m-d');                  
        $dvlk_semesters = $this->get_data_dvlk_semesters($params);                
        $kpis = $this->kpis_interface->get_data_kpis($params);   
        // $currentMonth = Carbon::now()->format('Y-m');
        // foreach ($data->data as $employee) {
        //     $employee->currentMonthKpis = collect($employee->kpis)->filter(function ($kpi) use ($currentMonth) {
        //         return Carbon::parse($kpi->from_date)->format('Y-m') == $currentMonth ||
        //             Carbon::parse($kpi->to_date)->format('Y-m') == $currentMonth;
        //     });
        // }                       

        return view('crm.content.taskManagement.task_target', compact('data', 'kpiStatus', 'dvlk_semesters', 'kpis'));
    }
   
}
