<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DidNumber extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number', 'number_type', 'area_code', 'city', 'monthly_fee', 'status',
    ];

    protected $casts = [
        'monthly_fee' => 'decimal:2',
    ];

    public function assignments()
    {
        return $this->hasMany(CustomerDidAssignment::class);
    }

    public function activeAssignment()
    {
        return $this->hasOne(CustomerDidAssignment::class)->where('status', 'active');
    }

    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }
}
