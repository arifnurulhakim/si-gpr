<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyCardRequest extends Model
{
    protected $fillable = [
        'family_id',
        'request_type',
        'request_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'request_date' => 'date',
    ];

    public function family(): BelongsTo
    {
        return $this->belongsTo(Family::class);
    }
}
