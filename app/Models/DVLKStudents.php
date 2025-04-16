<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DVLKStudents extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'dvlk_students';
    protected $fillable = [
        'id',
        'students_code',
        'students_name',
        'students_status',
        'students_academy',
        'students_majors',
        'students_sources',
        'students_sources_id',
        'note',
        'created_by',
        'updated_by',
        'deleted_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];   
    public function dvlk_transactions() {
        return $this->hasMany(DVLKTransactions::class,'students_id', 'id' );
    }
}
