<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionTypes extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'transactions_types';
    protected $fillable = [
        'id','name','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];

    public function leads() {
        return $this->hasMany(Leads::class, 'tran_types_id', 'id');
    }
    
}
