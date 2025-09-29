<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kartu Keluarga - {{ $family->family_card_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
        }

        .family-info {
            margin-bottom: 25px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .info-table td {
            padding: 8px 12px;
            border: 1px solid #333;
            vertical-align: top;
        }

        .info-table .label {
            background-color: #f5f5f5;
            font-weight: bold;
            width: 30%;
        }

        .info-table .value {
            width: 70%;
        }

        .members-section {
            margin-top: 25px;
        }

        .members-section h3 {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 15px 0;
            text-transform: uppercase;
            text-align: center;
            background-color: #f5f5f5;
            padding: 8px;
            border: 1px solid #333;
        }

        .members-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }

        .members-table th,
        .members-table td {
            padding: 6px 8px;
            border: 1px solid #333;
            text-align: left;
            vertical-align: top;
        }

        .members-table th {
            background-color: #f5f5f5;
            font-weight: bold;
            text-align: center;
        }

        .members-table .center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        .page-break {
            page-break-before: always;
        }

        @media print {
            body {
                margin: 0;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>Pemerintah Republik Indonesia</h1>
        <h2>Kartu Keluarga</h2>
    </div>

    <!-- Family Information -->
    <div class="family-info">
        <table class="info-table">
            <tr>
                <td class="label">Nomor Kartu Keluarga</td>
                <td class="value">{{ $family->family_card_number }}</td>
            </tr>
            <tr>
                <td class="label">Nama Kepala Keluarga</td>
                <td class="value">{{ $family->head_of_family_name }}</td>
            </tr>
            <tr>
                <td class="label">Alamat</td>
                <td class="value">{{ $family->address }}</td>
            </tr>
            <tr>
                <td class="label">RT/RW</td>
                <td class="value">RT {{ $family->rt }} / RW {{ $family->rw }}</td>
            </tr>
            <tr>
                <td class="label">Desa/Kelurahan</td>
                <td class="value">{{ $family->village }}</td>
            </tr>
            <tr>
                <td class="label">Kecamatan</td>
                <td class="value">{{ $family->sub_district }}</td>
            </tr>
            <tr>
                <td class="label">Kota/Kabupaten</td>
                <td class="value">{{ $family->city }}</td>
            </tr>
            <tr>
                <td class="label">Provinsi</td>
                <td class="value">{{ $family->province }}</td>
            </tr>
            <tr>
                <td class="label">Kode Pos</td>
                <td class="value">{{ $family->postal_code }}</td>
            </tr>
            @if($family->block)
            <tr>
                <td class="label">Blok</td>
                <td class="value">{{ $family->block }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Status</td>
                <td class="value">{{ ucfirst($family->status) }}</td>
            </tr>
        </table>
    </div>

    <!-- Family Members -->
    <div class="members-section">
        <h3>Anggota Keluarga</h3>
        <table class="members-table">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 18%;">NIK</th>
                    <th style="width: 20%;">Nama Lengkap</th>
                    <th style="width: 8%;">Jenis Kelamin</th>
                    <th style="width: 12%;">Tempat, Tanggal Lahir</th>
                    <th style="width: 8%;">Umur</th>
                    <th style="width: 12%;">Status Perkawinan</th>
                    <th style="width: 12%;">Hubungan</th>
                    <th style="width: 5%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($family->familyMembers->sortBy(function($member) {
                    return $member->relationship_to_head === 'Kepala Keluarga' ? 0 : 1;
                }) as $index => $member)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>{{ $member->nik }}</td>
                    <td>{{ $member->name }}</td>
                    <td class="center">{{ $member->gender == 'L' ? 'L' : 'P' }}</td>
                    <td>{{ $member->date_of_birth->format('d/m/Y') }}</td>
                    <td class="center">{{ \Carbon\Carbon::parse($member->date_of_birth)->age }}</td>
                    <td>{{ $member->marital_status }}</td>
                    <td>{{ $member->relationship_to_head }}</td>
                    <td class="center">{{ ucfirst($member->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>E-Kartu Keluarga System</p>
    </div>
</body>
</html>
