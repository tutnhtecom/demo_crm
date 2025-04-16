<?php

namespace App\Repositories;
use App\Models\TransactionStatus;

class TransactionStatusRepository extends BaseRepository
{
    public $model;
    public function __construct(TransactionStatus $model)
    {        
        $this->model = $model;        
    }
    
}
