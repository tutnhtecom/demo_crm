<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDidAssignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'did_number_id', 'customer_id', 'customer_subscription_id',
        'sip_connection_id', 'routing_type', 'routing_config',
        'assigned_date', 'expiry_date', 'status', 'notes',
    ];

    protected $casts = [
        'routing_config'  => 'array',
        'assigned_date'   => 'date',
        'expiry_date'     => 'date',
    ];

    public function didNumber()
    {
        return $this->belongsTo(DidNumber::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subscription()
    {
        return $this->belongsTo(CustomerSubscription::class, 'customer_subscription_id');
    }

    public function sipConnection()
    {
        return $this->belongsTo(SipConnection::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
