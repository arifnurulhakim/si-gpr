<?php

namespace App\Exports;

use App\Models\Family;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Carbon\Carbon;

class FamiliesExport implements FromArray, WithHeadings, WithStyles, WithColumnFormatting, WithColumnWidths, WithEvents
{
    /**
    * @return array
    */
    public function array(): array
    {
        $families = Family::with('familyMembers')->get();
        $data = [];

        foreach ($families as $family) {
            // Sort family members to ensure head of family is first
            $sortedMembers = $family->familyMembers->sortBy(function($member) {
                return $member->relationship_to_head === 'Kepala Keluarga' ? 0 : 1;
            });

            $isFirstMember = true;
            foreach ($sortedMembers as $member) {
                $age = Carbon::parse($member->date_of_birth)->age;

                $data[] = [
                    $isFirstMember ? "'" . $family->family_card_number : '', // No KK dengan prefix ' untuk text
                    "'" . $member->nik, // NIK dengan prefix ' untuk text
                    $isFirstMember ? $family->address : '', // Alamat hanya di kepala keluarga
                    $isFirstMember ? "RT {$family->rt} / RW {$family->rw}" : '', // RT/RW hanya di kepala keluarga
                    $isFirstMember ? ($family->block ?? '') : '', // Blok hanya di kepala keluarga
                    $member->name,
                    $member->date_of_birth->format('d/m/Y'),
                    $member->gender == 'L' ? 'Laki-laki' : 'Perempuan',
                    $age,
                    $member->relationship_to_head,
                    $member->citizenship,
                    ucfirst($member->status)
                ];

                $isFirstMember = false;
            }
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'No KK',
            'NIK',
            'Alamat',
            'RT/RW',
            'Blok',
            'Nama',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Umur',
            'Status Hubungan',
            'Kewarganegaraan',
            'Status'
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    /**
     * @return array
     */
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT, // No KK as text
            'B' => NumberFormat::FORMAT_TEXT, // NIK as text
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 25, // No KK - lebih lebar untuk nomor panjang
            'B' => 20, // NIK - lebih lebar untuk nomor panjang
            'C' => 40, // Alamat - lebih lebar untuk alamat lengkap
            'D' => 15, // RT/RW - cukup untuk format "RT 001 / RW 005"
            'E' => 12, // Blok - cukup untuk format "D1-12"
            'F' => 30, // Nama - lebih lebar untuk nama lengkap
            'G' => 15, // Tanggal Lahir - cukup untuk format "15/03/1985"
            'H' => 15, // Jenis Kelamin - cukup untuk "Laki-laki/Perempuan"
            'I' => 8,  // Umur - cukup untuk angka 1-3 digit
            'J' => 25, // Status Hubungan - lebih lebar untuk "KEPALA KELUARGA"
            'K' => 15, // Kewarganegaraan - cukup untuk "WNI/WNA"
            'L' => 12, // Status - cukup untuk "Tetap/Domisili"
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Set format text untuk kolom A (No KK) dan B (NIK)
                $sheet->getStyle('A:A')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);
                $sheet->getStyle('B:B')->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

                // Set semua cell di kolom A dan B sebagai text
                $highestRow = $sheet->getHighestRow();
                for ($row = 2; $row <= $highestRow; $row++) {
                    $sheet->setCellValueExplicit('A' . $row, $sheet->getCell('A' . $row)->getValue(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                    $sheet->setCellValueExplicit('B' . $row, $sheet->getCell('B' . $row)->getValue(), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
                }

                // Auto-size columns berdasarkan konten
                foreach (range('A', 'L') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(true);
                }
            },
        ];
    }
}
