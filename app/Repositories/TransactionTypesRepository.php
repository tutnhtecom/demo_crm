<?php

namespace App\Repositories;

use App\Models\TransactionTypes;

class TransactionTypesRepository extends BaseRepository
{
    public $model;
    public function __construct(TransactionTypes $model)
    {        
        $this->model = $model;        
    }
    
}
