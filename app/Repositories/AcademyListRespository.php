<?php

namespace App\Repositories;

use App\Models\AcademicTerms;
use App\Models\AcademyList;
class AcademyListRespository extends BaseRepository
{
    public $model;
    public function __construct(AcademyList $model)
    {        
        $this->model = $model;        
    }
    
}
