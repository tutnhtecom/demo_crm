<?php

namespace App\Repositories;

use App\Models\NotificationsGroups;

class NotificationsGroupsRepository extends BaseRepository
{
    public $model;
    public function __construct(NotificationsGroups $model)
    {        
        $this->model = $model;        
    }
    
}
