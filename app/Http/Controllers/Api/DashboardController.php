<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFilterRequest;
use App\Services\Dashboard\DashboardInterface;

class DashboardController extends Controller
{
    protected $da_interface;
    public function __construct(DashboardInterface $da_interface)
    {
        $this->da_interface = $da_interface;
    }
    public function report_new_leads(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_new_leads($params);
    }
    public function report_profile_success(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_profile_success($params);
    }
    public function report_to_students(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_to_students($params);
    }
    public function report_total_leads(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_total_leads($params);
    }
    public function rate_converts(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_by_status($params);
    }
    public function report_by_status(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_by_status($params);
    }
    public function report_price_by_marjors(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_price_by_marjors($params);
    }

    public function report_total_price_by_sources(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_total_price_by_sources($params);
    }
    public function report_quantity_leads_by_date(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_quantity_leads_by_date($params);
    }
    public function report_rate_leads_for_marjors(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_rate_leads_for_marjors($params);
    }
    public function report_rate_leads_for_status(DashboardFilterRequest $request)
    {
        $params = $request->all();
        return $this->da_interface->report_rate_leads_for_status($params);
    }
    public function get_list_new_leads()
    {
        return $this->da_interface->get_list_new_leads();
    }

    public function statistical_overview(DashboardFilterRequest $request){
        $param = $request->all();
        $report_new_leads = $this->da_interface->report_new_leads($param);
        $report_profile_success = $this->da_interface->report_profile_success($param);
        $report_to_students = $this->da_interface->report_to_students($param);
        $report_total_leads = $this->da_interface->report_total_leads($param);
        $rate_converts = $this->da_interface->rate_converts($param);
        $report_by_status = $this->da_interface->report_by_status($param);
        $data = [
            'report_new_leads'  => $report_new_leads,
            'report_profile_success' => $report_profile_success,
            'report_to_students' => $report_to_students,
            'report_total_leads' => $report_total_leads,
            'rate_converts' => $rate_converts,
            'report_by_status' => $report_by_status,
        ];
        return response()->json([
            "code"       => 200,
            "data"  => $data
        ]);
    }
}
