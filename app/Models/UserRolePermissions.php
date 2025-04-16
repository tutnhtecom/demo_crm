<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRolePermissions extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'users_roles_permissions';
    protected $fillable = [
       'id','users_id','roles_id','permissions_id','created_at','updated_at','deleted_at'
    ];
    public function users() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function roles() {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
    public function permissions() {
        return $this->belongsTo(Permissions::class, 'permissions_id', 'id');
    }
}
