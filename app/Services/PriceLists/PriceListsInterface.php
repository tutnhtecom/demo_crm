<?php

namespace App\Services\PriceLists;

interface PriceListsInterface
{       
    public function index($params);
    public function details($id);
    public function create($params);        
    public function create_multiple($params);    
    public function update($params, $id);
    public function delete($id);
    public function update_status($params, $id);
    public function update_file_pdf($params, $id);
    public function update_note($params, $id);
    public function imports($params);
}
