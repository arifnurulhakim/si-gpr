<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CashRecord extends Model
{
    protected $fillable = [
        'family_id',
        'cash_period_id',
        'cash_amount',
        'patrol_amount',
        'other_amount',
        'total_payment',
        'payment_status',
        'payment_proof_path',
        'payment_proof_uploaded_at',
        'verified_by',
        'verified_at',
        'rejection_reason',
        'recorded_by',
        'recorded_at',
    ];

    protected $casts = [
        'cash_amount' => 'decimal:2',
        'patrol_amount' => 'decimal:2',
        'other_amount' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'payment_proof_uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'recorded_at' => 'datetime',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function cashPeriod(): BelongsTo
    {
        return $this->belongsTo(CashPeriod::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if payment proof file exists
     */
    public function hasPaymentProofFile(): bool
    {
        return $this->payment_proof_path && Storage::disk('public')->exists($this->payment_proof_path);
    }

    /**
     * Get payment proof URL if file exists
     */
    public function getPaymentProofUrlAttribute(): ?string
    {
        return $this->hasPaymentProofFile() ? asset('storage/' . $this->payment_proof_path) : null;
    }

    /**
     * Get total amount for this record
     */
    public function getTotalAmountAttribute()
    {
        return $this->cash_amount + $this->patrol_amount + $this->other_amount;
    }
}
