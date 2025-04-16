<?php

namespace App\Repositories;

use App\Models\ConfigVoip;

class ConfigVoipRepository extends BaseRepository
{
    public $model;
    public function __construct(ConfigVoip $model)
    {        
        $this->model = $model;        
    }
    
}
