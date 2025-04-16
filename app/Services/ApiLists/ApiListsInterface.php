<?php

namespace App\Services\ApiLists;

interface ApiListsInterface
{       
    public function create($params);
    public function index($params);    
    public function details($id);    
    public function import($params); 
    public function update($params, $id);
    public function delete($id);
}
