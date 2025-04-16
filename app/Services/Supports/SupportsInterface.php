<?php

namespace App\Services\Supports;

interface SupportsInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);    
    public function createMultiple($params);    
    public function update($params, $id);
    public function delete($id);
    public function export($params);
    public function update_reply($params, $id);
    public function auto_update_status_support();
}
