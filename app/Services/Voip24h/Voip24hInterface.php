<?php

namespace App\Services\Voip24h;

interface Voip24hInterface
{       
    // public function filter($params);
    public function index($params);
    public function details($id);
    public function create($params);  
    public function update($params, $id);
    public function delete($id);
    
}
