<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSubscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'customer_id', 'service_package_id', 'contract_number',
        'start_date', 'end_date', 'billing_cycle_start', 'billing_cycle_end',
        'actual_price', 'allocated_minutes', 'used_minutes', 'status', 'notes',
    ];

    protected $casts = [
        'start_date'           => 'date',
        'end_date'             => 'date',
        'billing_cycle_start'  => 'date',
        'billing_cycle_end'    => 'date',
        'actual_price'         => 'decimal:2',
    ];

    protected $appends = ['usage_percentage', 'is_expiring_soon'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
    }

    public function sipConnections()
    {
        return $this->hasMany(SipConnection::class);
    }

    public function didAssignments()
    {
        return $this->hasMany(CustomerDidAssignment::class);
    }

    public function callLogs()
    {
        return $this->hasMany(CallLog::class);
    }

    public function minuteUsageSummaries()
    {
        return $this->hasMany(MinuteUsageSummary::class);
    }

    public function getUsagePercentageAttribute(): float
    {
        if ($this->allocated_minutes == 0) return 0;
        return round(($this->used_minutes / $this->allocated_minutes) * 100, 2);
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->billing_cycle_end) return false;
        return $this->billing_cycle_end->diffInDays(now()) <= 7;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiringSoon($query, int $days = 7)
    {
        return $query->where('billing_cycle_end', '<=', now()->addDays($days))
                     ->where('status', 'active');
    }
}
