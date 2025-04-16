<?php

namespace App\Services\Affiliate;

interface AffiliateInterface
{   
    public function get_data_transaction($params, $id);
    public function details_semesters($id);
    public function delete_semesters($id);
    public function create_semesters($params);
    public function update_semesters($params, $id);
    public function imports_transactions($params);
    public function auto_create_semesters();
    public function get_data_commission_for_affiliate($params, $id);
    public function data_semesters($params);
    public function export_overview($params);
    public function export_details($id);
}
