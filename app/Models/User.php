<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'nik',
        'block',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get the resident block associated with this user
     */
    public function residentBlock()
    {
        return $this->hasOne(ResidentBlock::class, 'block', 'block');
    }

    /**
     * Get the family through resident block (1 block = 1 KK)
     */
    public function family()
    {
        return $this->hasOneThrough(
            Family::class,
            ResidentBlock::class,
            'block', // Foreign key on resident_blocks table
            'id', // Foreign key on families table
            'block', // Local key on users table
            'family_id' // Local key on resident_blocks table
        );
    }

    /**
     * Find user by block and NIK for authentication
     */
    public static function findByBlockAndNik(string $block, string $nik)
    {
        return self::where('block', $block)
                   ->where('nik', $nik)
                   ->first();
    }

    /**
     * Find user by email or NIK for flexible login
     */
    public static function findByEmailOrNik(string $identifier)
    {
        // Check if it's an email
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return self::where('email', $identifier)->first();
        }

        // Check if it's a NIK (16 digits)
        if (preg_match('/^\d{16}$/', $identifier)) {
            return self::where('nik', $identifier)->first();
        }

        return null;
    }

    /**
     * Create user from resident block
     */
    public static function createFromResidentBlock(ResidentBlock $residentBlock)
    {
        $familyMember = $residentBlock->resident;

        return self::create([
            'name' => $familyMember->name,
            'email' => $familyMember->nik . '@resident.local', // Temporary email
            'password' => bcrypt($familyMember->nik), // Password is NIK
            'role' => 'user',
            'nik' => $familyMember->nik,
            'block' => $residentBlock->block,
        ]);
    }
}
