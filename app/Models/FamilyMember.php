<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class FamilyMember extends Model
{
    protected $fillable = [
        'family_id',
        'nik',
        'name',
        'gender',
        'date_of_birth',
        'marital_status',
        'relationship_to_head',
        'citizenship',
        'status',
        'ktp_image',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'family_id' => 'integer',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function familyCardEvents(): HasMany
    {
        return $this->hasMany(FamilyCardEvent::class);
    }

    /**
     * Get the resident block assignment for this family member
     */
    public function residentBlock(): HasOne
    {
        return $this->hasOne(ResidentBlock::class, 'resident_id');
    }

    /**
     * Scope to get family members without a family
     */
    public function scopeWithoutFamily($query)
    {
        return $query->whereNull('family_id');
    }

    /**
     * Scope to get family members with a family
     */
    public function scopeWithFamily($query)
    {
        return $query->whereNotNull('family_id');
    }

    /**
     * Check if this family member belongs to a family
     */
    public function hasFamily(): bool
    {
        return !is_null($this->family_id);
    }

    /**
     * Assign this family member to a family
     */
    public function assignToFamily(int $familyId): bool
    {
        $this->family_id = $familyId;
        return $this->save();
    }

    /**
     * Remove this family member from their current family
     */
    public function removeFromFamily(): bool
    {
        $this->family_id = null;
        return $this->save();
    }
}
