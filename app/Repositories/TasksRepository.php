<?php

namespace App\Repositories;

use App\Models\Tasks;
use App\Models\TransactionTypes;

class TasksRepository extends BaseRepository
{
    public $model;
    public function __construct(Tasks $model)
    {        
        $this->model = $model;        
    }
    
}
