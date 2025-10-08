<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class WaterUsageRecord extends Model
{
    protected $fillable = [
        'family_id',
        'block_id',
        'water_period_id',
        'initial_meter_reading',
        'final_meter_reading',
        'usage_amount',
        'bill_amount',
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
        'initial_meter_reading' => 'decimal:2',
        'final_meter_reading' => 'decimal:2',
        'usage_amount' => 'decimal:2',
        'bill_amount' => 'decimal:2',
        'total_payment' => 'decimal:2',
        'payment_proof_uploaded_at' => 'datetime',
        'verified_at' => 'datetime',
        'recorded_at' => 'datetime',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function residentBlock(): BelongsTo
    {
        return $this->belongsTo(ResidentBlock::class, 'block_id');
    }

    public function waterPeriod(): BelongsTo
    {
        return $this->belongsTo(WaterPeriod::class);
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
}
