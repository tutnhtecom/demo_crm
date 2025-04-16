<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permissions extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'permissions';
    protected $fillable = [
        'id','router_name','display_name','name','parent_id','code','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by','router_web_name'
    ];
    public function parent() {
        return $this->belongsTo(Permissions::class, 'parent_id', 'id');
    }
    public function rPermissions() {
        return $this->hasMany(RolePermissions::class, 'roles_id', 'id');
    }
    public function uRolePermissions() {
        return $this->hasMany(UserRolePermissions::class, 'permissions_id', 'id');
    }
}
