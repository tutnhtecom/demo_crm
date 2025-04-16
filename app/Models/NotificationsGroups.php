<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationsGroups extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'notifications_groups';
    protected $fillable = [
        'id','name','types','list_id','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];
}
