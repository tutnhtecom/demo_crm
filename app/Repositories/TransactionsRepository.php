<?php

namespace App\Repositories;

use App\Models\Transactions;

class TransactionsRepository extends BaseRepository
{
    public $model;
    public function __construct(Transactions $model)
    {        
        $this->model = $model;        
    }
    
}
