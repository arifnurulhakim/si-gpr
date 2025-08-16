<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FamilyCardRequest;
use App\Models\Family;
use Carbon\Carbon;

class FamilyCardRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = Family::all();

        $requestTypes = [
            'Pembuatan KK Baru',
            'Perubahan Data KK',
            'Penambahan Anggota Keluarga',
            'Pengurangan Anggota Keluarga',
            'Pindah Alamat',
            'Penggantian KK Rusak/Hilang',
            'Pemisahan KK',
            'Penggabungan KK',
            'Perubahan Status Kepala Keluarga',
            'Update Data Anggota Keluarga'
        ];

        $statuses = ['PENDING', 'APPROVED', 'REJECTED'];

        $requestNotes = [
            'Pembuatan KK Baru' => [
                'Keluarga baru setelah menikah',
                'Pemisahan dari orang tua',
                'Pindah dari daerah lain',
                'Keluarga baru setelah perceraian',
                'Pembentukan keluarga mandiri'
            ],
            'Perubahan Data KK' => [
                'Perubahan nama setelah menikah',
                'Koreksi kesalahan penulisan nama',
                'Update alamat detail',
                'Perubahan status perkawinan',
                'Update data pekerjaan'
            ],
            'Penambahan Anggota Keluarga' => [
                'Kelahiran anak baru',
                'Adopsi anak',
                'Pernikahan anak',
                'Kepindahan saudara',
                'Reunifikasi keluarga'
            ],
            'Pengurangan Anggota Keluarga' => [
                'Anggota keluarga meninggal dunia',
                'Anak pindah setelah menikah',
                'Pindah ke daerah lain',
                'Pemisahan karena kuliah',
                'Emigrasi ke luar negeri'
            ],
            'Pindah Alamat' => [
                'Pindah rumah dalam satu RT/RW',
                'Pindah ke RT/RW berbeda',
                'Pindah karena renovasi rumah',
                'Pindah karena beli rumah baru',
                'Pindah sementara'
            ],
            'Penggantian KK Rusak/Hilang' => [
                'KK rusak karena banjir',
                'KK hilang saat pindahan',
                'KK robek tidak sengaja',
                'KK hilang saat bepergian',
                'KK rusak karena usia'
            ],
            'Pemisahan KK' => [
                'Anak menikah dan mandiri',
                'Konflik dalam keluarga',
                'Keperluan administrasi',
                'Pembagian warisan',
                'Kemandirian ekonomi'
            ],
            'Penggabungan KK' => [
                'Reunifikasi setelah perceraian',
                'Penggabungan karena ekonomi',
                'Merawat orang tua',
                'Efisiensi administrasi',
                'Keperluan khusus'
            ],
            'Perubahan Status Kepala Keluarga' => [
                'Kepala keluarga meninggal dunia',
                'Pergantian karena usia',
                'Kepala keluarga sakit permanen',
                'Pergantian karena emigrasi',
                'Perubahan sesuai kesepakatan keluarga'
            ],
            'Update Data Anggota Keluarga' => [
                'Update pendidikan terbaru',
                'Perubahan status pekerjaan',
                'Update nomor telepon',
                'Perubahan status kesehatan',
                'Update dokumen identitas'
            ]
        ];

        // Create specific requests for the first 8 families
        $specificRequests = [
            [
                'family_id' => 1,
                'request_type' => 'Penambahan Anggota Keluarga',
                'request_date' => Carbon::create(2023, 6, 15),
                'status' => 'APPROVED',
                'notes' => 'Penambahan anggota keluarga karena kelahiran anak ketiga',
            ],
            [
                'family_id' => 1,
                'request_type' => 'Perubahan Data KK',
                'request_date' => Carbon::create(2024, 1, 10),
                'status' => 'PENDING',
                'notes' => 'Update alamat detail setelah renovasi rumah',
            ],
            [
                'family_id' => 2,
                'request_type' => 'Perubahan Status Kepala Keluarga',
                'request_date' => Carbon::create(2022, 8, 5),
                'status' => 'APPROVED',
                'notes' => 'Perubahan status dari istri menjadi kepala keluarga setelah perceraian',
            ],
            [
                'family_id' => 2,
                'request_type' => 'Penggantian KK Rusak/Hilang',
                'request_date' => Carbon::create(2023, 11, 20),
                'status' => 'APPROVED',
                'notes' => 'Penggantian KK yang hilang saat pindahan',
            ],
            [
                'family_id' => 3,
                'request_type' => 'Pembuatan KK Baru',
                'request_date' => Carbon::create(2021, 3, 12),
                'status' => 'APPROVED',
                'notes' => 'Pembuatan KK baru setelah pindah dari Jakarta',
            ],
            [
                'family_id' => 3,
                'request_type' => 'Penambahan Anggota Keluarga',
                'request_date' => Carbon::create(2024, 2, 28),
                'status' => 'PENDING',
                'notes' => 'Penambahan menantu setelah anak menikah',
            ],
            [
                'family_id' => 4,
                'request_type' => 'Perubahan Data KK',
                'request_date' => Carbon::create(2023, 9, 14),
                'status' => 'APPROVED',
                'notes' => 'Perubahan nama istri setelah menikah dengan kepala keluarga',
            ],
            [
                'family_id' => 5,
                'request_type' => 'Pembuatan KK Baru',
                'request_date' => Carbon::create(2023, 4, 18),
                'status' => 'APPROVED',
                'notes' => 'Pembuatan KK baru untuk keluarga mandiri',
            ],
            [
                'family_id' => 6,
                'request_type' => 'Pindah Alamat',
                'request_date' => Carbon::create(2023, 12, 3),
                'status' => 'PENDING',
                'notes' => 'Pindah alamat ke RT berbeda dalam satu kelurahan',
            ],
            [
                'family_id' => 7,
                'request_type' => 'Update Data Anggota Keluarga',
                'request_date' => Carbon::create(2024, 1, 25),
                'status' => 'PENDING',
                'notes' => 'Update data pekerjaan kepala keluarga',
            ],
            [
                'family_id' => 8,
                'request_type' => 'Penambahan Anggota Keluarga',
                'request_date' => Carbon::create(2023, 10, 7),
                'status' => 'APPROVED',
                'notes' => 'Penambahan anak angkat dalam keluarga',
            ],
        ];

        foreach ($specificRequests as $request) {
            FamilyCardRequest::create($request);
        }

        // Generate random requests for remaining families
        $remainingFamilies = $families->skip(8);

        foreach ($remainingFamilies as $family) {
            $requestCount = rand(1, 3); // Random number of requests per family

            for ($i = 0; $i < $requestCount; $i++) {
                $requestType = $requestTypes[array_rand($requestTypes)];
                $status = $statuses[array_rand($statuses)];
                $notes = $requestNotes[$requestType][array_rand($requestNotes[$requestType])];

                FamilyCardRequest::create([
                    'family_id' => $family->id,
                    'request_type' => $requestType,
                    'request_date' => Carbon::create(rand(2020, 2024), rand(1, 12), rand(1, 28)),
                    'status' => $status,
                    'notes' => $notes,
                ]);
            }
        }
    }
}
