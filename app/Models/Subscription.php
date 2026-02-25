<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'customer_id',
        'package_id',
        'created_by',
        'billing_cycle',
        'price_at_subscription',
        'start_date',
        'end_date',
        'next_billing_date',
        'status',
        'auto_renew',
        'cancel_reason',
        'cancelled_at',
        'cancelled_by',
        'notes',
    ];

    protected $casts = [
        'start_date'            => 'date',
        'end_date'              => 'date',
        'next_billing_date'     => 'date',
        'cancelled_at'          => 'datetime',
        'auto_renew'            => 'boolean',
        'price_at_subscription' => 'decimal:2',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(AdminUser::class, 'created_by');
    }

    public function cancelledBy()
    {
        return $this->belongsTo(AdminUser::class, 'cancelled_by');
    }

    public function sipAccounts()
    {
        return $this->hasMany(SipAccount::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiringSoon($query, int $days = 7)
    {
        return $query->where('status', 'active')
                     ->whereBetween('end_date', [now(), now()->addDays($days)]);
    }

    // ─── Helpers ─────────────────────────────────────────────────────

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isExpired(): bool
    {
        return $this->end_date->isPast();
    }
}