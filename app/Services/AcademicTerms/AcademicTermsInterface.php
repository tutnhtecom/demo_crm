<?php

namespace App\Services\AcademicTerms;

interface AcademicTermsInterface
{       
    public function create($params);
    public function index($params);    
    public function details($id);    
    public function import($params); 
    public function update($params, $id);
    public function update_leads_to_academic($params, $id);    
    public function delete($id);
}
