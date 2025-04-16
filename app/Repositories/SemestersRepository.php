<?php

namespace App\Repositories;
use App\Models\Semesters;

class SemestersRepository extends BaseRepository
{
    public $model;
    public function __construct(Semesters $model)
    {        
        $this->model = $model;        
    }
    
   
}
