<?php

namespace App\Services\Semesters;

interface SemestersInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);
    public function createMultiple($params);        
    public function update($params, $id);
    public function delete($id);
    public function data_config();
    public function update_semesters_config($params, $id);
}
