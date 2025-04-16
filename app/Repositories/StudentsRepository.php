<?php

namespace App\Repositories;

use App\Models\Leads;
use App\Models\Students;

class StudentsRepository extends BaseRepository
{
    public $model;
    public function __construct(Students $model)
    {
        $this->model = $model;        
    }
    
}
