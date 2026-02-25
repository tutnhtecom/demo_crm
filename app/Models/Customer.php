<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens; // Import the trait here

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'code',
        'full_name',
        'email',
        'phone',
        'id_card',
        'address',
        'province',
        'customer_type',
        'company_name',
        'tax_code',
        'balance',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'balance'           => 'decimal:2',
        'status'            => 'string',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latestOfMany();
    }

    public function sipAccounts()
    {
        return $this->hasMany(SipAccount::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSearch($query, string $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('full_name', 'like', "%{$keyword}%")
              ->orWhere('email', 'like', "%{$keyword}%")
              ->orWhere('phone', 'like', "%{$keyword}%")
              ->orWhere('code', 'like', "%{$keyword}%");
        });
    }

    // ─── Accessors ───────────────────────────────────────────────────

    public function getIsBusinessAttribute(): bool
    {
        return $this->customer_type === 'business';
    }
}