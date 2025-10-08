<?php

namespace App\Exports;

use App\Models\CashPeriod;
use App\Models\CashRecord;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CashPeriodExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $period;

    public function __construct(CashPeriod $period)
    {
        $this->period = $period;
    }

    public function collection()
    {
        return CashRecord::where('cash_period_id', $this->period->id)
            ->with(['family', 'residentBlock.resident', 'cashPeriod'])
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
            'Uang Kas',
            'Uang Ronda',
            'Lain-lain',
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
            'Rp ' . number_format($record->cash_amount),
            'Rp ' . number_format($record->patrol_amount),
            'Rp ' . number_format($record->other_amount),
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
            'F' => 18,  // Uang Kas
            'G' => 18,  // Uang Ronda
            'H' => 18,  // Lain-lain
            'I' => 18,  // Total Tagihan
            'J' => 20,  // Status Pembayaran
            'K' => 20,  // Tanggal Input
            'L' => 30,  // Catatan
        ];
    }
}
