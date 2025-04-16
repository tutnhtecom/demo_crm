<?php

namespace App\Repositories;

use App\Models\AcademicTerms;
use App\Models\LineVoip;
class Voip24hRepository extends BaseRepository
{
    public $model;
    public function __construct(LineVoip $model)
    {        
        $this->model = $model;        
    }
    
}
