<?php

namespace App\Services\Leads;

interface LeadsInterface
{       
    public function create($params);     
    public function uAvatar($params, $id);
    public function uPersonal($params, $id);     
    public function contacts($params, $id);     
    public function family($params, $id); 
    public function score($params, $id);    
    public function confirm($params, $id);  
    public function register_with_sources($params, $sources);   
    public function forgot_password($param);
    //crm
    public function data($params); 
    public function details($id);    
    public function update($params, $id);
    public function crm_create_lead($params);
    public function update_status_lead($params, $id);
    public function delete($id);
    public function delete_multiple($params);    
    public function export($params);
    public function import($params);
    public function active($params);
    public function getDataFilter();
    public function update_employees($params, $id);
    public function create_leads_from_support($params);
    public function update_custom_fields($params, $id);
    public function get_status_history($id);
    public function get_notification_birthday();
    public function import_code_for_leads($params);
}
