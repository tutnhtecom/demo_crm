<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SipAccount extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'subscription_id',
        'sip_username',
        'sip_password',
        'sip_domain',
        'display_name',
        'extension',
        'did_number',
        'caller_id',
        'status',
        'registration_status',
        'last_registered_ip',
        'last_registered_at',
        'notes',
    ];

    protected $hidden = ['sip_password'];

    protected $casts = [
        'last_registered_at' => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
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

    public function scopeRegistered($query)
    {
        return $query->where('registration_status', 'registered');
    }
}