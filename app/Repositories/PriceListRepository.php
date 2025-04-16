<?php

namespace App\Repositories;

use App\Models\PriceLists;

class PriceListRepository extends BaseRepository
{
    public $model;
    public function __construct(PriceLists $model)
    {        
        $this->model = $model;        
    }
    
}
