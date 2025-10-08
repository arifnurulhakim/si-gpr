<?php

namespace App\Exports;

use App\Models\WaterPeriod;
use App\Models\WaterUsageRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WaterPeriodExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $period;

    public function __construct(WaterPeriod $period)
    {
        $this->period = $period;
    }

    public function collection()
    {
        return WaterUsageRecord::where('water_period_id', $this->period->id)
            ->with(['family', 'residentBlock.resident', 'waterPeriod'])
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nomor KK',
            'Nama Kepala Keluarga',
            'Blok',
            'Nama Warga',
            'Pemakaian (M3)',
            'Harga per M3',
            'Total Tagihan',
            'Status Pembayaran',
            'Tanggal Input',
            'Catatan'
        ];
    }

    public function map($record): array
    {
        static $no = 1;

        return [
            $no++,
            $record->family ? $record->family->family_card_number : '-',
            $record->family ? $record->family->head_of_family_name : '-',
            $record->residentBlock ? $record->residentBlock->block : '-',
            $record->residentBlock && $record->residentBlock->resident ? $record->residentBlock->resident->name : '-',
            $record->usage_amount,
            'Rp ' . number_format($this->period->price_per_m3),
            'Rp ' . number_format($record->total_payment),
            $record->payment_status,
            $record->created_at->format('d/m/Y H:i'),
            $record->notes ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as header
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // No
            'B' => 20,  // Nomor KK
            'C' => 25,  // Nama Kepala Keluarga
            'D' => 12,  // Blok
            'E' => 25,  // Nama Warga
            'F' => 15,  // Pemakaian (M3)
            'G' => 18,  // Harga per M3
            'H' => 18,  // Total Tagihan
            'I' => 20,  // Status Pembayaran
            'J' => 20,  // Tanggal Input
            'K' => 30,  // Catatan
        ];
    }
}
