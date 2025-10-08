<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaterPeriod extends Model
{
    protected $fillable = [
        'period_name',
        'period_code',
        'due_date',
        'price_per_m3',
        'admin_fee',
        'status',
        'block',
        'target_type',
        'target_value',
        'created_by',
    ];

    protected $casts = [
        'due_date' => 'date',
        'price_per_m3' => 'decimal:2',
        'admin_fee' => 'decimal:2',
    ];

    public function waterUsageRecords(): HasMany
    {
        return $this->hasMany(WaterUsageRecord::class);
    }

    public function waterMeterPhotos(): HasMany
    {
        return $this->hasMany(WaterMeterPhoto::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope untuk periode aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'ACTIVE');
    }

    // Scope untuk periode yang belum ditutup
    public function scopeOpen($query)
    {
        return $query->whereIn('status', ['ACTIVE', 'PENDING']);
    }

    // Scope untuk periode berdasarkan blok
    public function scopeByBlock($query, $block)
    {
        return $query->where('block', $block);
    }

    // Scope untuk periode semua blok
    public function scopeAllBlocks($query)
    {
        return $query->whereNull('block');
    }
}
