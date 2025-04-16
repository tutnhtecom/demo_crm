<?php

namespace App\Repositories;

use App\Models\LeadsAcademicTerms;

class LeadsAcademicTermsRepository extends BaseRepository
{
    public $model;
    public function __construct(LeadsAcademicTerms $model)
    {        
        $this->model = $model;        
    }
    
}
