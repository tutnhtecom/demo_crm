<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jobs extends Model
{
    use HasFactory;
    use SoftDeletes;    
    protected $table = 'jobs';
    protected $fillable = [
        'id','title', 'email', 'types', 'leads_id', 'employees_id', 'students_id', 'image_url','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];  
    
}