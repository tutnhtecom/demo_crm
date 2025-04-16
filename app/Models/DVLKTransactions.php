<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DVLKTransactions extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'dvlk_transactions';
    protected $fillable = [
        'id',
        'students_id',
        'semesters_id',
        'tran_academy',
        'tran_price',
        'tran_debt',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at',

    ];   

    public function dvlk_students() {
        return $this->belongsTo(DVLKStudents::class,'students_id', 'id');
    }
    public function dvlk_semesters() {
        return $this->belongsTo(DVLKSemesters::class, 'semesters_id', 'id');
    }
}

