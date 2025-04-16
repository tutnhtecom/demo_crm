<?php

namespace App\Repositories;

use App\Models\Kpis;

class KpisRepository extends BaseRepository
{
    public $model;
    public function __construct(Kpis $model)
    {        
        $this->model = $model;        
    }
    
}
