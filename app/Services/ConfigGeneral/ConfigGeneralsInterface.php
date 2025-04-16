<?php

namespace App\Services\ConfigGeneral;

interface ConfigGeneralsInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);            
    public function update($params, $id);
    public function delete($id);    
}
