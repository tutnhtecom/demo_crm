<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kpis extends Model
{
    use SoftDeletes;
    use HasFactory;    

    protected $table = 'kpis';    
    protected $fillable = [
        'id','employees_id','price','quantity','from_date','to_date',
        'created_at','updated_at','deleted_at','created_by','updated_by','deleted_by', 'semesters_id'
    ];
    public function employees() {
        return $this->belongsTo(Employees::class, 'employees_id', 'id');
    }
}
