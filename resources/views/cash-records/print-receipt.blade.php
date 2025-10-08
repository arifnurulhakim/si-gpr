<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran Tagihan Kas</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Courier New', monospace;
            font-size: 10px;
            line-height: 1.2;
            color: #000;
            background: #fff;
            padding: 5px;
            margin: 0;
        }

        .receipt {
            width: 8cm;
            min-height: 15cm;
            margin: 0 auto;
            background: #fff;
            padding: 5px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .company-name {
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .receipt-title {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 3px;
        }

        .company-code {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .info-section {
            margin-bottom: 8px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
            font-size: 9px;
        }

        .info-label {
            font-weight: normal;
            min-width: 70px;
            font-size: 8px;
        }

        .info-value {
            font-weight: normal;
            text-align: right;
            flex: 1;
            font-size: 8px;
            word-break: break-all;
            overflow-wrap: break-word;
        }

        .status-value {
            font-weight: bold;
            text-transform: uppercase;
        }

        .transfer-section {
            text-align: center;
            margin: 8px 0;
        }

        .transfer-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 9px;
        }

        .transfer-info {
            margin-bottom: 3px;
            font-size: 8px;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-style: italic;
            font-size: 8px;
        }

        .payment-info {
            margin-bottom: 8px;
            padding: 5px;
            border: 1px solid #000;
        }

        .payment-confirmation {
            text-align: center;
            margin: 8px 0;
            padding: 5px;
            border: 1px solid #000;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .receipt {
                width: 8cm;
                min-height: 15cm;
                margin: 0;
                padding: 5px;
            }

            .no-print {
                display: none !important;
            }

            @page {
                size: 8cm 15cm;
                margin: 0;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #000;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background: #333;
        }

        /* Force black and white for all elements */
        * {
            color: #000 !important;
            background-color: #fff !important;
            border-color: #000 !important;
        }

        /* Ensure no colors in print */
        @media print {
            * {
                color: #000 !important;
                background-color: #fff !important;
                border-color: #000 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <button class="print-button no-print" onclick="window.print()">🖨️ Cetak</button>

    <div class="receipt">
        <div class="header">
            <div class="company-name">TIRTA GRIYA PASOPATI REGENCY</div>
            <div class="receipt-title">STRUK PEMBAYARAN TAGIHAN</div>
            <div class="company-code">TIRTA GPR</div>
        </div>

        @if($cashRecord->payment_status === 'LUNAS' && $cashRecord->verified_at)
        <div class="payment-info">
            <div class="info-row">
                <span class="info-label">TANGGAL BAYAR</span>
                <span class="info-value">{{ $cashRecord->verified_at->format('d/m/Y H.i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">DIVERIFIKASI OLEH</span>
                <span class="info-value">{{ strtoupper($cashRecord->verifiedBy->name ?? 'ADMIN') }}</span>
            </div>
        </div>
        @endif

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">TANGGAL</span>
                <span class="info-value">{{ now()->format('d/m/y H.i') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NO ID</span>
                <span class="info-value">{{ $cashRecord->family ? $cashRecord->family->family_card_number : 'Blok ' . $cashRecord->residentBlock->block }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NAMA</span>
                <span class="info-value">{{ $cashRecord->family ? strtoupper(substr($cashRecord->family->head_of_family_name, 0, 20)) . (strlen($cashRecord->family->head_of_family_name) > 20 ? '...' : '') : 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">ALAMAT</span>
                <span class="info-value">{{ $cashRecord->family ? strtoupper(substr($cashRecord->family->address, 0, 25)) . (strlen($cashRecord->family->address) > 25 ? '...' : '') : 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">BLOK</span>
                <span class="info-value">{{ strtoupper($cashRecord->residentBlock->block ?? '-') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">PERIODE</span>
                <span class="info-value">{{ strtoupper($cashPeriod->period_name) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">UANG KAS</span>
                <span class="info-value">{{ number_format($cashRecord->cash_amount, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">UANG RONDA</span>
                <span class="info-value">{{ number_format($cashRecord->patrol_amount, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">LAIN-LAIN</span>
                <span class="info-value">{{ number_format($cashRecord->other_amount, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">BIAYA ADM</span>
                <span class="info-value">{{ $cashPeriod->admin_fee > 0 ? number_format($cashPeriod->admin_fee, 2, ',', '.') : '-' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">TOTAL BAYAR</span>
                <span class="info-value">{{ number_format($cashRecord->total_payment, 2, ',', '.') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">STATUS</span>
                <span class="info-value status-value">
                    @switch($cashRecord->payment_status)
                        @case('PENDING')
                            BELUM LUNAS
                            @break
                        @case('OVERDUE')
                            BELUM LUNAS
                            @break
                        @case('PAYMENT_UPLOADED')
                            MENUNGGU VERIFIKASI
                            @break
                        @case('LUNAS')
                            LUNAS
                            @break
                        @case('REJECTED')
                            DITOLAK
                            @break
                        @default
                            BELUM LUNAS
                    @endswitch
                </span>
            </div>
        </div>

        @if($cashRecord->payment_status !== 'LUNAS')
        <div class="transfer-section">
            <div class="transfer-title">Pembayaran Bisa Di Transfer ke :</div>
            <div class="transfer-info">Mandiri - 1070025111974 - Yudi Sambas Jupari</div>
            <div class="transfer-info">Dana - 082122001974 - Yudi Sambas Jupari</div>
        </div>
        @else
        <div class="payment-confirmation">
            <div class="transfer-title">PEMBAYARAN TELAH DILAKUKAN</div>
            <div class="transfer-info">Status: LUNAS</div>
            @if($cashRecord->verified_at)
            <div class="transfer-info">Tanggal Verifikasi: {{ $cashRecord->verified_at->format('d/m/Y H:i') }}</div>
            @endif
        </div>
        @endif

        <div class="footer">
            @if($cashRecord->payment_status === 'LUNAS')
            Simpanlah struk ini sebagai bukti pembayaran Anda.
            @endif
            <br>
            ~ Terima Kasih ~
        </div>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() {
        //     window.print();
        // }
    </script>
</body>
</html>
