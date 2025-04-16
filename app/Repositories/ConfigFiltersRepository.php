<?php

namespace App\Repositories;

use App\Models\ConfigFilter;

class ConfigFiltersRepository extends BaseRepository
{
    public $model;
    public function __construct(ConfigFilter $model)
    {        
        $this->model = $model;        
    }
    
}
