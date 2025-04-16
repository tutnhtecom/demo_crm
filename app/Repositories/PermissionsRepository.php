<?php

namespace App\Repositories;

use App\Models\Permissions;

class PermissionsRepository extends BaseRepository
{
    public $model;
    public function __construct(Permissions $model)
    {        
        $this->model = $model;        
    }
    
}
