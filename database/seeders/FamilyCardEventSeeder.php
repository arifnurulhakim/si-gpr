<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyCardEvent;
use App\Models\Family;
use App\Models\FamilyMember;
use Carbon\Carbon;

class FamilyCardEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = Family::all();
        $familyMembers = FamilyMember::all();

        $eventTypes = [
            'Kelahiran',
            'Kematian',
            'Pindah Masuk',
            'Pindah Keluar',
            'Perubahan Status',
            'Pernikahan',
            'Perceraian',
            'Perubahan Nama',
            'Perubahan Alamat',
            'Penambahan Anggota Keluarga'
        ];

        $eventDescriptions = [
            'Kelahiran' => [
                'Kelahiran anak pertama dalam keluarga',
                'Kelahiran anak kedua',
                'Kelahiran anak kembar',
                'Kelahiran bayi dengan berat normal',
                'Kelahiran prematur namun sehat'
            ],
            'Kematian' => [
                'Meninggal dunia karena sakit',
                'Meninggal dunia karena usia lanjut',
                'Meninggal dunia karena kecelakaan',
                'Meninggal dunia di rumah sakit',
                'Meninggal dunia secara mendadak'
            ],
            'Pindah Masuk' => [
                'Pindah dari kota lain ke wilayah ini',
                'Pindah dari provinsi lain',
                'Pindah karena pekerjaan',
                'Pindah karena menikah',
                'Pindah karena pendidikan'
            ],
            'Pindah Keluar' => [
                'Pindah ke kota lain',
                'Pindah ke provinsi lain',
                'Pindah karena pekerjaan baru',
                'Pindah karena kuliah',
                'Pindah mengikuti suami/istri'
            ],
            'Perubahan Status' => [
                'Perubahan status dari belum kawin menjadi kawin',
                'Perubahan status dari kawin menjadi janda/duda',
                'Perubahan status kewarganegaraan',
                'Perubahan status pekerjaan',
                'Perubahan status pendidikan'
            ],
            'Pernikahan' => [
                'Pernikahan dengan warga setempat',
                'Pernikahan dengan warga luar daerah',
                'Pernikahan secara agama Islam',
                'Pernikahan secara agama Kristen',
                'Pernikahan secara sipil'
            ],
            'Perceraian' => [
                'Perceraian dengan kesepakatan bersama',
                'Perceraian melalui pengadilan',
                'Perceraian karena tidak ada kecocokan',
                'Perceraian karena masalah ekonomi',
                'Perceraian karena faktor lain'
            ],
            'Perubahan Nama' => [
                'Perubahan nama karena pernikahan',
                'Perubahan nama karena adopsi',
                'Perubahan nama karena konversi agama',
                'Perubahan nama sesuai akta kelahiran baru',
                'Perubahan nama karena kesalahan penulisan'
            ],
            'Perubahan Alamat' => [
                'Perubahan alamat dalam satu RT/RW',
                'Perubahan alamat antar RT/RW',
                'Perubahan alamat detail rumah',
                'Perubahan alamat karena renovasi',
                'Perubahan alamat sementara'
            ],
            'Penambahan Anggota Keluarga' => [
                'Penambahan anggota karena kelahiran',
                'Penambahan anggota karena adopsi',
                'Penambahan anggota karena pernikahan',
                'Penambahan anggota karena pindah masuk',
                'Penambahan anggota karena reunifikasi keluarga'
            ]
        ];

        // Create events for the first 5 families with specific data
        $specificEvents = [
            // Family 1 Events
            [
                'family_id' => 1,
                'family_member_id' => 3, // Andi Santoso
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2010, 5, 10),
                'description' => 'Kelahiran anak pertama bernama Andi Santoso',
            ],
            [
                'family_id' => 1,
                'family_member_id' => 4, // Putri Santoso
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2013, 12, 3),
                'description' => 'Kelahiran anak kedua bernama Putri Santoso',
            ],
            [
                'family_id' => 1,
                'family_member_id' => 1, // Budi Santoso
                'event_type' => 'Perubahan Alamat',
                'event_date' => Carbon::create(2020, 6, 15),
                'description' => 'Perubahan alamat detail rumah karena renovasi',
            ],

            // Family 2 Events
            [
                'family_id' => 2,
                'family_member_id' => 5, // Siti Rahayu
                'event_type' => 'Perceraian',
                'event_date' => Carbon::create(2015, 3, 20),
                'description' => 'Perceraian melalui pengadilan agama',
            ],
            [
                'family_id' => 2,
                'family_member_id' => 6, // Rina Rahayu
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2005, 4, 18),
                'description' => 'Kelahiran anak pertama bernama Rina Rahayu',
            ],
            [
                'family_id' => 2,
                'family_member_id' => 7, // Doni Rahayu
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2008, 9, 25),
                'description' => 'Kelahiran anak kedua bernama Doni Rahayu',
            ],

            // Family 3 Events
            [
                'family_id' => 3,
                'family_member_id' => 8, // Ahmad Wijaya
                'event_type' => 'Pindah Masuk',
                'event_date' => Carbon::create(1995, 8, 10),
                'description' => 'Pindah dari Jakarta karena pekerjaan',
            ],
            [
                'family_id' => 3,
                'family_member_id' => 9, // Ani Wijaya
                'event_type' => 'Pernikahan',
                'event_date' => Carbon::create(1998, 11, 21),
                'description' => 'Pernikahan dengan Ahmad Wijaya',
            ],
            [
                'family_id' => 3,
                'family_member_id' => 10, // Bima Wijaya
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2000, 10, 5),
                'description' => 'Kelahiran anak pertama bernama Bima Wijaya',
            ],

            // Family 4 Events
            [
                'family_id' => 4,
                'family_member_id' => 13, // Dewi Lestari
                'event_type' => 'Pernikahan',
                'event_date' => Carbon::create(2010, 7, 17),
                'description' => 'Pernikahan dengan Raka Pratama',
            ],
            [
                'family_id' => 4,
                'family_member_id' => 15, // Kirana Pratama
                'event_type' => 'Kelahiran',
                'event_date' => Carbon::create(2012, 11, 16),
                'description' => 'Kelahiran anak pertama bernama Kirana Pratama',
            ],

            // Family 5 Events
            [
                'family_id' => 5,
                'family_member_id' => 16, // Eko Prasetyo
                'event_type' => 'Pindah Masuk',
                'event_date' => Carbon::create(2018, 1, 12),
                'description' => 'Pindah dari Bandung karena pekerjaan baru',
            ],
        ];

        foreach ($specificEvents as $event) {
            FamilyCardEvent::create($event);
        }

        // Generate random events for remaining families
        $remainingFamilies = $families->skip(5);

        foreach ($remainingFamilies as $family) {
            $eventCount = rand(1, 4); // Random number of events per family
            $familyMemberIds = $family->familyMembers->pluck('id')->toArray();

            for ($i = 0; $i < $eventCount; $i++) {
                $eventType = $eventTypes[array_rand($eventTypes)];
                $description = $eventDescriptions[$eventType][array_rand($eventDescriptions[$eventType])];

                FamilyCardEvent::create([
                    'family_id' => $family->id,
                    'family_member_id' => !empty($familyMemberIds) ? $familyMemberIds[array_rand($familyMemberIds)] : null,
                    'event_type' => $eventType,
                    'event_date' => Carbon::create(rand(2000, 2024), rand(1, 12), rand(1, 28)),
                    'description' => $description,
                ]);
            }
        }
    }
}
