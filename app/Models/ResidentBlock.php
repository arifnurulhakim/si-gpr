<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ResidentBlock extends Model
{
    protected $table = 'resident_blocks';

    protected $fillable = [
        'block',
        'resident_id',
        'family_id',
    ];

    /**
     * Get the resident that owns this block assignment
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class, 'resident_id');
    }

    /**
     * Get the family associated with this block (1 block = 1 KK)
     */
    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class, 'family_id');
    }

    /**
     * Check if block format is valid
     */
    public static function isValidBlockFormat(string $block): bool
    {
        // Format: D1-12, D1-12A, etc.
        // Pattern: Letter-Number-Number or Letter-Number-Number-Letter
        return preg_match('/^[A-Z]\d+-\d+[A-Z]?$/', $block);
    }

    /**
     * Scope to get blocks by block code
     */
    public function scopeByBlock($query, string $block)
    {
        return $query->where('block', $block);
    }

    /**
     * Get all unique blocks
     */
    public static function getUniqueBlocks()
    {
        return self::select('block')
                   ->distinct()
                   ->orderBy('block')
                   ->pluck('block');
    }

    /**
     * Get water usage records for this block
     */
    public function waterUsageRecords(): HasMany
    {
        return $this->hasMany(WaterUsageRecord::class, 'block_id');
    }

    /**
     * Get cash records for this block
     */
    public function cashRecords(): HasMany
    {
        return $this->hasMany(CashRecord::class, 'block_id');
    }
}
