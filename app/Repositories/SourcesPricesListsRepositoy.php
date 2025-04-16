<?php

namespace App\Repositories;

use App\Models\SourcesPricesLists;

class SourcesPricesListsRepositoy extends BaseRepository
{
    public $model;
    public function __construct(SourcesPricesLists $model)
    {        
        $this->model = $model;        
    }
    
}
