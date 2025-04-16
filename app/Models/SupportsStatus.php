<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportsStatus extends Model
{
    use SoftDeletes;
    use HasFactory;

    const STATUS_NEWS  = 1;
    const STATUS_OPEN  = 2;
    const STATUS_REPLY = 3;
    const STATUS_CLOSE = 4;

    protected $table = 'supports_status';
    protected $fillable = [
        'id','name','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by',
        "color","bg_color","border_color"
    ];
    public function support() {
        return $this->hasMany(Supports::class, 'sp_status_id', 'id');
    }    
}
