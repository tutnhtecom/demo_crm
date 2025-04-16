<?php

namespace App\Repositories;

use App\Models\ConfigSemesters;
class ConfigSemestersRepository extends BaseRepository
{
    public $model;
    public function __construct(ConfigSemesters $model)
    {        
        $this->model = $model;        
    }
    
}
