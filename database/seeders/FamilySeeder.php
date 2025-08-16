<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Family;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            [
                'family_card_number' => '3201012345678901',
                'head_of_family_name' => 'Budi Santoso',
                'address' => 'Jl. Merdeka No. 123',
                'rt' => '001',
                'rw' => '005',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678902',
                'head_of_family_name' => 'Siti Rahayu',
                'address' => 'Jl. Pancasila No. 45',
                'rt' => '002',
                'rw' => '003',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'domisili',
            ],
            [
                'family_card_number' => '3201012345678903',
                'head_of_family_name' => 'Ahmad Wijaya',
                'address' => 'Jl. Gatot Subroto No. 78',
                'rt' => '003',
                'rw' => '007',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678904',
                'head_of_family_name' => 'Dewi Lestari',
                'address' => 'Jl. Sudirman No. 234',
                'rt' => '004',
                'rw' => '002',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678905',
                'head_of_family_name' => 'Eko Prasetyo',
                'address' => 'Jl. Diponegoro No. 67',
                'rt' => '005',
                'rw' => '001',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'domisili',
            ],
            [
                'family_card_number' => '3201012345678906',
                'head_of_family_name' => 'Rina Marlina',
                'address' => 'Jl. Ahmad Yani No. 89',
                'rt' => '006',
                'rw' => '004',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678907',
                'head_of_family_name' => 'Hendra Gunawan',
                'address' => 'Jl. Kartini No. 156',
                'rt' => '007',
                'rw' => '006',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678908',
                'head_of_family_name' => 'Maya Sari',
                'address' => 'Jl. Veteran No. 321',
                'rt' => '008',
                'rw' => '008',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678909',
                'head_of_family_name' => 'Rudi Hermawan',
                'address' => 'Jl. Pahlawan No. 112',
                'rt' => '009',
                'rw' => '009',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
            [
                'family_card_number' => '3201012345678910',
                'head_of_family_name' => 'Linda Sartika',
                'address' => 'Jl. Proklamasi No. 445',
                'rt' => '010',
                'rw' => '010',
                'village' => 'Sukamaju',
                'sub_district' => 'Cipayung',
                'city' => 'Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16740',
                'status' => 'tetap',
            ],
        ];

        foreach ($families as $family) {
            Family::create($family);
        }
    }
}
