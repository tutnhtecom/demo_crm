<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigSemesters extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'config_semesters';
    protected $fillable = [
        'id','name','from_day','from_month','to_day','to_month','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];   
}
