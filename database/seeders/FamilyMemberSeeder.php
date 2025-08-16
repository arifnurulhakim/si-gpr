<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyMember;
use App\Models\Family;
use Carbon\Carbon;

class FamilyMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = Family::all();

        $familyMemberData = [
            // Family 1: Budi Santoso
            [
                'family_id' => 1,
                'nik' => '3201011234567890',
                'name' => 'Budi Santoso',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(1985, 3, 15),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'KEPALA KELUARGA',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 1,
                'nik' => '3201011234567891',
                'name' => 'Sari Wulandari',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(1987, 8, 22),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'ISTRI',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 1,
                'nik' => '3201011234567892',
                'name' => 'Andi Santoso',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(2010, 5, 10),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 1,
                'nik' => '3201011234567893',
                'name' => 'Putri Santoso',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(2013, 12, 3),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],

            // Family 2: Siti Rahayu (Status: domisili)
            [
                'family_id' => 2,
                'nik' => '3201011234567894',
                'name' => 'Siti Rahayu',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(1980, 11, 7),
                'marital_status' => 'CERAI MATI',
                'relationship_to_head' => 'KEPALA KELUARGA',
                'citizenship' => 'WNI',
                'status' => 'domisili',
            ],
            [
                'family_id' => 2,
                'nik' => '3201011234567895',
                'name' => 'Rina Rahayu',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(2005, 4, 18),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'domisili',
            ],
            [
                'family_id' => 2,
                'nik' => '3201011234567896',
                'name' => 'Doni Rahayu',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(2008, 9, 25),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'domisili',
            ],

            // Family 3: Ahmad Wijaya
            [
                'family_id' => 3,
                'nik' => '3201011234567897',
                'name' => 'Ahmad Wijaya',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(1975, 6, 12),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'KEPALA KELUARGA',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 3,
                'nik' => '3201011234567898',
                'name' => 'Ani Wijaya',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(1978, 2, 28),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'ISTRI',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 3,
                'nik' => '3201011234567899',
                'name' => 'Bima Wijaya',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(2000, 10, 5),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 3,
                'nik' => '3201011234567800',
                'name' => 'Cinta Wijaya',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(2003, 7, 14),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 3,
                'nik' => '3201011234567801',
                'name' => 'Dimas Wijaya',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(2015, 1, 20),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],

            // Family 4: Dewi Lestari
            [
                'family_id' => 4,
                'nik' => '3201011234567802',
                'name' => 'Dewi Lestari',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(1983, 12, 30),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'KEPALA KELUARGA',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 4,
                'nik' => '3201011234567803',
                'name' => 'Raka Pratama',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(1981, 4, 8),
                'marital_status' => 'KAWIN',
                'relationship_to_head' => 'SUAMI',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],
            [
                'family_id' => 4,
                'nik' => '3201011234567804',
                'name' => 'Kirana Pratama',
                'gender' => 'P',
                'date_of_birth' => Carbon::create(2012, 11, 16),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'ANAK',
                'citizenship' => 'WNI',
                'status' => 'tetap',
            ],

            // Family 5: Eko Prasetyo (Status: domisili)
            [
                'family_id' => 5,
                'nik' => '3201011234567805',
                'name' => 'Eko Prasetyo',
                'gender' => 'L',
                'date_of_birth' => Carbon::create(1990, 5, 3),
                'marital_status' => 'BELUM KAWIN',
                'relationship_to_head' => 'KEPALA KELUARGA',
                'citizenship' => 'WNI',
                'status' => 'domisili',
            ],
        ];

        foreach ($familyMemberData as $member) {
            FamilyMember::create($member);
        }

        // Generate additional random family members for remaining families
        $remainingFamilies = $families->skip(5);

        foreach ($remainingFamilies as $family) {
            $memberCount = rand(2, 5); // Random number of members per family

            for ($i = 0; $i < $memberCount; $i++) {
                $isHead = $i === 0;
                $gender = rand(0, 1) ? 'L' : 'P';

                $names = [
                    'L' => ['Agus', 'Bambang', 'Candra', 'Dedi', 'Edi', 'Fajar', 'Galih', 'Hadi', 'Indra', 'Joko'],
                    'P' => ['Ayu', 'Bella', 'Citra', 'Dian', 'Eka', 'Fitri', 'Gita', 'Hani', 'Indah', 'Jihan']
                ];

                $relationships = $isHead ? 'KEPALA KELUARGA' : ['ISTRI', 'SUAMI', 'ANAK', 'ORANGTUA', 'FAMILI LAIN'][rand(0, 4)];
                $maritalStatuses = ['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'];

                $memberStatus = ['tetap', 'domisili'][rand(0, 1)];

                FamilyMember::create([
                    'family_id' => $family->id,
                    'nik' => '32010112345' . str_pad($family->id, 3, '0', STR_PAD_LEFT) . str_pad($i + 1, 2, '0', STR_PAD_LEFT),
                    'name' => $names[$gender][rand(0, 9)] . ' ' . (explode(' ', $family->head_of_family_name)[1] ?? 'Family'),
                    'gender' => $gender,
                    'date_of_birth' => Carbon::create(rand(1950, 2020), rand(1, 12), rand(1, 28)),
                    'marital_status' => $isHead ? 'KAWIN' : $maritalStatuses[rand(0, 3)],
                    'relationship_to_head' => $relationships,
                    'citizenship' => 'WNI',
                    'status' => $memberStatus,
                ]);
            }
        }
    }
}
