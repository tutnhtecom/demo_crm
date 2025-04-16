<?php

namespace App\Repositories;

use App\Models\SourcesRates;

class SourcesRateRepository extends BaseRepository
{
    public $model;
    public function __construct(SourcesRates $model)
    {        
        $this->model = $model;        
    }
    
}
