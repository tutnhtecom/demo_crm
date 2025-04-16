<?php

namespace App\Repositories;

use App\Models\ConfigGeneral;
use App\Models\ConfigSemesters;
class ConfigGeneralRepository extends BaseRepository
{
    public $model;
    public function __construct(ConfigGeneral $model)
    {        
        $this->model = $model;        
    }
    
}
