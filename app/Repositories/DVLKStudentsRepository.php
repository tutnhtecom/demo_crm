<?php

namespace App\Repositories;

use App\Models\DVLKStudents;

class DVLKStudentsRepository extends BaseRepository
{
    public $model;
    public function __construct(DVLKStudents $model)
    {        
        $this->model = $model;        
    }
    
}
