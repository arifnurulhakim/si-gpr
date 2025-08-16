<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyCardEvent extends Model
{
    protected $fillable = [
        'family_id',
        'family_member_id',
        'event_type',
        'event_date',
        'description',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }

    public function familyMember(): BelongsTo
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
