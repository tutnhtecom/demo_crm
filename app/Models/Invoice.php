<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'customer_id',
        'subscription_id',
        'type',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'status',
        'paid_amount',
        'issue_date',
        'due_date',
        'paid_date',
        'period_from',
        'period_to',
        'notes',
    ];

    protected $casts = [
        'issue_date'      => 'date',
        'due_date'        => 'date',
        'paid_date'       => 'date',
        'period_from'     => 'date',
        'period_to'       => 'date',
        'subtotal'        => 'decimal:2',
        'tax_rate'        => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'paid_amount'     => 'decimal:2',
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

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────────

    public function scopeOverdue($query)
    {
        return $query->whereIn('status', ['issued', 'partially_paid'])
                     ->where('due_date', '<', now());
    }

    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', ['issued', 'partially_paid', 'overdue']);
    }

    // ─── Accessors ───────────────────────────────────────────────────

    public function getRemainingAmountAttribute(): float
    {
        return (float) $this->total_amount - (float) $this->paid_amount;
    }
}