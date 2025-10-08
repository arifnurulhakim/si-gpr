<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class WaterMeterPhoto extends Model
{
    protected $fillable = [
        'block_id',
        'water_period_id',
        'image_path',
        'uploaded_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the resident block associated with this photo
     */
    public function residentBlock(): BelongsTo
    {
        return $this->belongsTo(ResidentBlock::class, 'block_id');
    }

    /**
     * Get the water period associated with this photo
     */
    public function waterPeriod(): BelongsTo
    {
        return $this->belongsTo(WaterPeriod::class);
    }

    /**
     * Get the user who uploaded this photo
     */
    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Check if meter photo file exists
     */
    public function hasPhotoFile(): bool
    {
        return $this->image_path && Storage::disk('public')->exists($this->image_path);
    }

    /**
     * Get meter photo URL if file exists
     */
    public function getPhotoUrlAttribute(): ?string
    {
        return $this->hasPhotoFile() ? asset('storage/' . $this->image_path) : null;
    }

    /**
     * Delete the photo file from storage
     */
    public function deletePhotoFile(): bool
    {
        if ($this->hasPhotoFile()) {
            return Storage::disk('public')->delete($this->image_path);
        }
        return false;
    }
}

