<?php

namespace App\Repositories;

use App\Models\SourcesDetails;

class SourcesDetailsRepository extends BaseRepository
{
    public $model;
    public function __construct(SourcesDetails $model)
    {        
        $this->model = $model;        
    }
    
}
