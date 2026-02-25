<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_code',
        'customer_id',
        'invoice_id',
        'amount',
        'payment_method',
        'status',
        'gateway_transaction_id',
        'gateway_response',
        'description',
        'paid_at',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'amount'            => 'decimal:2',
        'gateway_response'  => 'array',
        'paid_at'           => 'datetime',
        'confirmed_at'      => 'datetime',
    ];

    // ─── Relationships ───────────────────────────────────────────────

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function confirmedBy()
    {
        return $this->belongsTo(AdminUser::class, 'confirmed_by');
    }
}