<?php

namespace App\Services\ConfigFilters;

interface ConfigFilterInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);            
    public function update($params, $id);
    public function delete($id);    
    // cấu hình voip 
    public function create_config_voip($params);            
    public function update_config_voip($params, $id);
}
