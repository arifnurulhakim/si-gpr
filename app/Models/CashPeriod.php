<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CashPeriod extends Model
{
    protected $fillable = [
        'period_name',
        'period_code',
        'due_date',
        'cash_amount',
        'patrol_amount',
        'other_amount',
        'admin_fee',
        'status',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'cash_amount' => 'decimal:2',
        'patrol_amount' => 'decimal:2',
        'other_amount' => 'decimal:2',
        'admin_fee' => 'decimal:2',
    ];

    public function cashRecords(): HasMany
    {
        return $this->hasMany(CashRecord::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['ACTIVE', 'PENDING']);
    }

    /**
     * Get total amount for this period
     */
    public function getTotalAmountAttribute()
    {
        return $this->cash_amount + $this->patrol_amount + $this->other_amount + $this->admin_fee;
    }
}
