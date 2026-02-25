<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'price_monthly',
        'price_yearly',
        'sip_account_limit',
        'concurrent_call_limit',
        'free_minutes_domestic',
        'free_minutes_international',
        'rate_per_minute_domestic',
        'rate_per_minute_international',
        'storage_gb',
        'features',
        'status',
        'sort_order',
    ];

    protected $casts = [
        'features'                      => 'array',
        'price_monthly'                 => 'decimal:2',
        'price_yearly'                  => 'decimal:2',
        'rate_per_minute_domestic'      => 'decimal:2',
        'rate_per_minute_international' => 'decimal:2',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscriptions()
    {
        return $this->hasMany(Subscription::class)->where('status', 'active');
    }

    // ─── Scopes ──────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('price_monthly');
    }
}