<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin and test users first
        $this->call([
            UserSeeder::class,
        ]);

        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed all family-related data
        $this->call([
            FamilySeeder::class,
            FamilyMemberSeeder::class,
            FamilyCardEventSeeder::class,
            FamilyCardRequestSeeder::class,
        ]);
    }
}
