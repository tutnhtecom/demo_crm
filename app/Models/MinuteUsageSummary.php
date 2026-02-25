<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MinuteUsageSummary extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id', 'customer_subscription_id', 'summary_date',
        'total_calls', 'answered_calls', 'total_minutes',
        'inbound_minutes', 'outbound_minutes', 'internal_minutes',
        'package_minutes_used', 'extra_minutes_used', 'extra_charge',
    ];

    protected $casts = [
        'summary_date' => 'date',
        'extra_charge' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(CustomerSubscription::class, 'customer_subscription_id');
    }
}
