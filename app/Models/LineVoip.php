<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LineVoip extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'line_voip';    
    protected $fillable = [
        "id","line_id","line_password","deleted_at","created_at","updated_at"
    ];
}
