<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employees extends Model
{
    use SoftDeletes;
    use HasFactory;
    const NOT_ACTIVE = 0;
    const ACTIVE = 1;
    const STATUS_MAP = [
        self::ACTIVE => 'Đang hoạt động',
        self::NOT_ACTIVE => 'Không hoạt động',
    ]; 
    protected $table = 'employees';
    protected $fillable = [
        'id',
        'name',
        'code',
        'roles_id',
        'email',
        'phone',
        'date_of_birth',
        'avatar',
        'status',
        'line_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function user()
    {
        return $this->hasone(User::class, 'email', 'email');
    }
    public function notifications()
    {
        return $this->belongsTo(Notifications::class, 'email', 'email');
    }
    public function leads()
    {
        return $this->hasMany(Leads::class, 'assignments_id', 'id');
    }

    public function students()
    {
        return $this->belongsTo(Students::class, 'assignments_id', 'id');
    }
    public function roles()
    {
        return $this->belongsTo(Roles::class, 'roles_id', 'id');
    }
    public function tasks()
    {
        return $this->hasMany(Tasks::class, 'employees_id', 'id');
    }
    public function kpis()
    {
        return $this->hasMany(Kpis::class, 'employees_id', 'id');
    }
    public function kReports()
    {
        return $this->hasMany(KpisReports::class, 'employees_id', 'id');
    }
    public function files()
    {
        return $this->hasMany(Files::class, 'employees_id', 'id');
    }
    public function lineVoip()
    {
        return $this->belongsTo(LineVoip::class, 'line_id', 'line_id');
    }
}
