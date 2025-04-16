<?php

namespace App\Repositories;

use App\Models\Nations;

class NationsRepository extends BaseRepository
{
    public $model;
    public function __construct(Nations $model)
    {        
        $this->model = $model;        
    }
    
}
