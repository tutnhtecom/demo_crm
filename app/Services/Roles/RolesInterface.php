<?php

namespace App\Services\Roles;
interface RolesInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);    
    public function createMultiple($params);    
    public function update($params, $id);
    public function delete($id);
    public function dataPermission();
    
}
