<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfigFilter extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'config_filter';
    protected $fillable = [
        "id",  "name",  "start_date",  "end_date",  "created_at",  "updated_at",  "deleted_at",  "created_by",  "updated_by",  "deleted_by"
    ];
}
