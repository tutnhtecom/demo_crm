<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigGeneral extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    const TYPES_KPIS        = 0;
    const TYPES_TASK        = 1;
    const TYPES_SUPPORTS    = 2;

    const TYPES_MAP_TEXT = [
        self::TYPES_KPIS => "kpis",
        self::TYPES_TASK => "task",
        self::TYPES_SUPPORTS => "supports",
    ];    

    protected $table = 'config_generals';
    protected $fillable = [
       'id','title','types','start_date','end_date','expired_date','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'
    ];   
}
