<?php

namespace App\Repositories;

use App\Models\RolePermissions;
use App\Models\Roles;
use App\Models\Sources;

class RolePermissionRepository extends BaseRepository
{
    public $model;
    public function __construct(RolePermissions $model)
    {        
        $this->model = $model;        
    }
    
}
