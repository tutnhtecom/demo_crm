<?php

namespace App\Services\Kpis;

interface KpisInterface
{   
    public function create($params); 
    public function update($params); 
    public function cron_data();
    public function data($params);
    public function get_data_kpis($params);
    public function details($id);
    public function create_notification_kpis_expired();    
}
