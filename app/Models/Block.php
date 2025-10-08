<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Block extends Model
{
    protected $fillable = [
        'block_code',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the family members that belong to this block
     */
    public function familyMembers(): BelongsToMany
    {
        return $this->belongsToMany(FamilyMember::class, 'family_member_blocks')
                    ->withPivot('nik')
                    ->withTimestamps();
    }

    /**
     * Scope to get only active blocks
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get only inactive blocks
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the count of family members in this block
     */
    public function getMemberCountAttribute(): int
    {
        return $this->familyMembers()->count();
    }

    /**
     * Check if block code format is valid
     */
    public static function isValidBlockCode(string $blockCode): bool
    {
        // Format: D1-12, D1-12A, etc.
        // Pattern: Letter-Number-Number or Letter-Number-Number-Letter
        return preg_match('/^[A-Z]\d+-\d+[A-Z]?$/', $blockCode);
    }
}