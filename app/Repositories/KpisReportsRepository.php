<?php

namespace App\Repositories;

use App\Models\KpisReports;
use App\Models\User;

class KpisReportsRepository extends BaseRepository
{
    public $model;
    public function __construct(KpisReports $model)
    {        
        $this->model = $model;        
    }
    
}
