<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'sip_account_id',
        'customer_id',
        'call_id',
        'caller_number',
        'callee_number',
        'direction',
        'call_type',
        'status',
        'started_at',
        'answered_at',
        'ended_at',
        'duration_seconds',
        'charge_amount',
        'recording_path',
    ];

    protected $casts = [
        'started_at'    => 'datetime',
        'answered_at'   => 'datetime',
        'ended_at'      => 'datetime',
        'charge_amount' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sipAccount()
    {
        return $this->belongsTo(SipAccount::class);
    }

    // Scope
    public function scopeAnswered($query)
    {
        return $query->where('status', 'answered');
    }

    public function scopeInPeriod($query, $from, $to)
    {
        return $query->whereBetween('started_at', [$from, $to]);
    }

    public function getDurationFormattedAttribute(): string
    {
        $minutes = intdiv($this->duration_seconds, 60);
        $seconds = $this->duration_seconds % 60;
        return sprintf('%02d:%02d', $minutes, $seconds);
    }
}