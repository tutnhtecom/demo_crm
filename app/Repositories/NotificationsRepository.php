<?php

namespace App\Repositories;

use App\Models\Notifications;

class NotificationsRepository extends BaseRepository
{
    public $model;
    public function __construct(Notifications $model)
    {        
        $this->model = $model;        
    }
    
}
