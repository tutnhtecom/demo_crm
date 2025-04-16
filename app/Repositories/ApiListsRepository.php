<?php

namespace App\Repositories;

use App\Models\ApiLists;
class ApiListsRepository extends BaseRepository
{
    public $model;
    public function __construct(ApiLists $model)
    {        
        $this->model = $model;        
    }
    
}
