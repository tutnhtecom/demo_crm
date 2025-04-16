<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermissions extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'roles_permissions';
    protected $fillable = [
        'id','roles_id', 'permissions_id'
    ];

    public function roles() {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
    public function permissions() {
        return $this->belongsTo(Permissions::class, 'permissions_id', 'id');
    }


}
