<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminUser extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admin_users';

    protected $fillable = [
        'username',
        'full_name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'last_login_at',
        'last_login_ip',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    // ─── Role checks ─────────────────────────────────────────────────

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function canManagePackages(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    // ─── Relationships ───────────────────────────────────────────────

    public function createdSubscriptions()
    {
        return $this->hasMany(Subscription::class, 'created_by');
    }

    public function confirmedPayments()
    {
        return $this->hasMany(Payment::class, 'confirmed_by');
    }
}