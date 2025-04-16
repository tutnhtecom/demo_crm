<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigVoip extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'config_voip';
    protected $fillable = [
        'id','api_key','api_secret','voip_ip','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by',    
    ];   
}
