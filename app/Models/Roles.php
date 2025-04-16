<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = [
        'id','name','slug','created_at','updated_at','deleted_at','created_by','updated_by','deleted_by'
    ];

    public function role_permissions() {
        return $this->hasMany(RolePermissions::class, 'roles_id', 'id');
    }
}
