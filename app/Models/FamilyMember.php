<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function familyCardEvents(): HasMany
    {
        return $this->hasMany(FamilyCardEvent::class);
    }
}
