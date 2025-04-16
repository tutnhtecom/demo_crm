<?php

namespace App\Repositories;

use App\Models\DVLKTransactions;

class DVLKTransactionsRepository extends BaseRepository
{
    public $model;
    public function __construct(DVLKTransactions $model)
    {        
        $this->model = $model;        
    }
    
}
