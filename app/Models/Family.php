<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    protected $fillable = [
        'family_card_number',
        'head_of_family_name',
        'address',
        'rt',
        'rw',
        'village',
        'sub_district',
        'city',
        'province',
        'postal_code',
        'status',
    ];

    public function familyMembers(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function familyCardEvents(): HasMany
    {
        return $this->hasMany(FamilyCardEvent::class);
    }

    public function familyCardRequests(): HasMany
    {
        return $this->hasMany(FamilyCardRequest::class);
    }
}
