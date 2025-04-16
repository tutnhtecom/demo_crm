<?php

namespace App\Repositories;

use App\Models\Roles;
use App\Models\Sources;

class RolesRepository extends BaseRepository
{
    public $model;
    public function __construct(Roles $model)
    {        
        $this->model = $model;        
    }
    
}
