<?php

namespace App\Services\Dashboard;

interface DashboardInterface
{
    public function report_new_leads($params);
    public function report_profile_success($params);
    public function report_to_students($params);
    public function report_total_leads($params);
    public function rate_converts($params);
    public function report_by_status($params);
    public function report_price_by_marjors($params);
    public function report_total_price_by_sources($params);
    public function report_quantity_leads_by_date($params);
    public function report_rate_leads_for_marjors($params);
    public function report_rate_leads_for_status($params);
    public function get_list_new_leads();
}
