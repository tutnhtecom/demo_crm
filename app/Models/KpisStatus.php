<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpisStatus extends Model
{    
    use HasFactory;    
    const ACTIVE = 1;
    const NOT_ACTIVE = 0;

    const GENDER_MAP = [
        self::ACTIVE => 'Có lưu',
        self::NOT_ACTIVE => 'Không lưu'        
    ];   

    protected $table = 'kpis_status';    
    protected $fillable = [
        'id','status','descripts','created_at','updated_at'
    ];    
}
