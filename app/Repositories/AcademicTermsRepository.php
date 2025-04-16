<?php

namespace App\Repositories;

use App\Models\AcademicTerms;
class AcademicTermsRepository extends BaseRepository
{
    public $model;
    public function __construct(AcademicTerms $model)
    {        
        $this->model = $model;        
    }
    
}
