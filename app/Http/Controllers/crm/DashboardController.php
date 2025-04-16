<?php

namespace App\Http\Controllers\crm;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardInterface;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $dashboard_interface;
    public function __construct(DashboardInterface $dashboard_interface)
    {
        $this->dashboard_interface = $dashboard_interface;
    }

    public function statistical(Request $request){
        $param = $request->all();
        $user = $request->auth;
        $report_new_leads = $this->dashboard_interface->report_new_leads($param);
        $report_profile_success = $this->dashboard_interface->report_profile_success($param);
        $report_to_students = $this->dashboard_interface->report_to_students($param);
        $data = [
            'user'              => $user,
            'report_new_leads'  => $report_new_leads,
            'report_profile_success' => $report_profile_success,
            'report_to_students' => $report_to_students,

        ];
        return view('crm.content.dashboard.statistical', $data);
     
    }

    public function statistical_overview(Request $request){
        $param = $request->all();
        $report_new_leads = $this->dashboard_interface->report_new_leads($param);
        $report_profile_success = $this->dashboard_interface->report_profile_success($param);
        $report_to_students = $this->dashboard_interface->report_to_students($param);
        $data = [
            'report_new_leads'  => $report_new_leads,
            'report_profile_success' => $report_profile_success,
            'report_to_students' => $report_to_students,

        ];
        return response()->json([
            "code"       => 200,
            "data"  => $data
        ]);
    }

    public function statistical_kpi(){
        return view('crm.content.dashboard.statistical_kpi');
    }
}
