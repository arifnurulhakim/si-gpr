<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'block',
        'status',
        'family_card_image',
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

    /**
     * Get the resident block associated with this family (1 block = 1 KK)
     */
    public function residentBlock(): HasOne
    {
        return $this->hasOne(ResidentBlock::class, 'family_id');
    }

    public function waterUsageRecords(): HasMany
    {
        return $this->hasMany(WaterUsageRecord::class);
    }

    public function pendingWaterBills()
    {
        return $this->waterUsageRecords()
            ->whereIn('payment_status', ['PENDING', 'OVERDUE', 'PAYMENT_UPLOADED'])
            ->with('waterPeriod');
    }

    public function overdueWaterBills()
    {
        return $this->waterUsageRecords()
            ->where('payment_status', 'OVERDUE')
            ->whereHas('waterPeriod', function($query) {
                $query->where('due_date', '<', now());
            });
    }

    /**
     * Get the user associated with this family
     */
    public function user()
    {
        return $this->hasOne(User::class, 'family_card_number', 'family_card_number');
    }

    /**
     * Get the cash records for this family
     */
    public function cashRecords(): HasMany
    {
        return $this->hasMany(CashRecord::class);
    }

    /**
     * Get pending cash bills for this family
     */
    public function pendingCashBills()
    {
        return $this->cashRecords()
            ->whereIn('payment_status', ['PENDING', 'OVERDUE', 'PAYMENT_UPLOADED'])
            ->with('cashPeriod');
    }

    /**
     * Get overdue cash bills for this family
     */
    public function overdueCashBills()
    {
        return $this->cashRecords()
            ->where('payment_status', 'OVERDUE')
            ->whereHas('cashPeriod', function($query) {
                $query->where('due_date', '<', now());
            });
    }

    /**
     * Add an existing family member to this family
     */
    public function addExistingMember(FamilyMember $member): bool
    {
        return $member->assignToFamily($this->id);
    }

    /**
     * Add multiple existing family members to this family
     */
    public function addExistingMembers(array $memberIds): bool
    {
        return FamilyMember::whereIn('id', $memberIds)
            ->whereNull('family_id')
            ->update(['family_id' => $this->id]) > 0;
    }

    /**
     * Remove a family member from this family
     */
    public function removeMember(FamilyMember $member): bool
    {
        if ($member->family_id === $this->id) {
            return $member->removeFromFamily();
        }
        return false;
    }
}
