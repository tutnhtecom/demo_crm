<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use SoftDeletes;
    use HasApiTokens, HasFactory, Notifiable;
    const TYPE_LEADS = 0;
    const TYPE_STUDENTS = 1;
    const TYPE_EMPLOYEES = 2;
   
    const ACTIVE = 1;
    const NOT_ACTIVE = 0;

    const IS_ROOT = 1;    
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'types',
        'email',
        'status',
        'password',
        'email_verified_at',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function employees(){
        return $this->hasOne(Employees::class, 'email', 'email');
    }
    public function leads(){
        return $this->hasOne(Employees::class, 'email', 'email');
    }
    public function students(){
        return $this->hasOne(Employees::class, 'email', 'email');
    }
    public function notifications()
    {
        return $this->belongsTo(Notifications::class, 'email', 'email');
    }
    public function uRolePermission(){
        return $this->hasMany(UserRolePermissions::class, 'users_id', 'id');
    }
    
}
