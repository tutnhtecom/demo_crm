<?php

namespace App\Services\Tasks;

interface TasksInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);      
    public function update($params, $id);
    public function update_status($params, $id);
    public function delete($id);
    public function getEmployees();
    
}
