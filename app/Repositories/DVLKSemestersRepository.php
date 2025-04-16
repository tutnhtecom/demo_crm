<?php

namespace App\Repositories;

use App\Models\DVLKSemesters;

class DVLKSemestersRepository extends BaseRepository
{
    public $model;
    public function __construct(DVLKSemesters $model)
    {        
        $this->model = $model;        
    }
    
}
