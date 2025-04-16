<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionStatus extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'transactions_status';
    protected $fillable = [
        'id','name','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'        
    ];

    public function transactions() {
        return $this->hasMany(Transactions::class, 'tran_status_id', 'id');
    }    
}
