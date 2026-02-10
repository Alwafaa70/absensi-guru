<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi Guru - SDN CIRANJANGGIRANG 2</title>
    <style>
        body { 
            font-family: 'Times New Roman', serif; 
            font-size: 12px; 
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
            font-weight: bold;
        }
        .header h2 {
            margin: 5px 0 0;
            font-size: 14px;
            font-weight: normal;
        }
        .header .address {
            margin-top: 5px;
            font-size: 11px;
            font-style: italic;
        }
        hr.double {
            border-top: 3px double #000;
            margin-bottom: 20px;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 5px;
            text-transform: uppercase;
        }
        .meta {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 30px;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 6px 4px; 
            text-align: center; 
        }
        th { 
            background-color: #f0f0f0; 
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        td {
            font-size: 11px;
        }
        .text-left { text-align: left; padding-left: 8px; }
        .footer {
            width: 100%;
            margin-top: 50px;
        }
        .signature-box {
            float: right;
            width: 200px;
            text-align: center;
        }
        .signature-name {
            margin-top: 60px;
            font-weight: bold;
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 150px;
        }
        .signature-nip {
            margin-top: 5px;
        }
        
        /* Utility Colors for Screen/PDF */
        .bg-green { background-color: #dcfce7; } /* Hijau Muda */
        .bg-red { background-color: #fee2e2; }   /* Merah Muda */
        .bg-yellow { background-color: #fef9c3; } /* Kuning Muda */
        .bg-blue { background-color: #dbeafe; }   /* Biru Muda */
    </style>
</head>
<body>

    <!-- KOP SURAT -->
    <div class="header">
        <h1>SDN CIRANJANGGIRANG 2</h1>
        <h2>PEMERINTAH KABUPATEN CIANJUR</h2>
        <div class="address">
            Alamat: Kampung Sumberharja , Neglasari,  Kec. Bojongpicung, Kab. Cianjur, Jawa Barat
        </div>
    </div>
    <hr class="double">

    <!-- JUDUL LAPORAN -->
    <div class="title">LAPORAN REKAPITULASI KEHADIRAN GURU</div>
    <div class="meta">
        Periode: {{ $startDate->locale('id')->isoFormat('D MMMM Y') }} - {{ $endDate->locale('id')->isoFormat('D MMMM Y') }}
    </div>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 25%">Nama Guru</th>
                <th style="width: 10%">Hadir</th>
                <th style="width: 10%">Izin</th>
                <th style="width: 10%">Sakit</th>
                <th style="width: 10%">Bolos</th>
                <th style="width: 10%">Waktu Telat<br>(Menit)</th>
                <th style="width: 10%">Hadir (%)</th>
                <th style="width: 10%">Bolos (%)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statistik as $index => $s)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="text-left">
                        <strong>{{ $s['name'] }}</strong><br>
                        <small>NIP: {{ $s['nip'] ?? '-' }}</small>
                    </td>
                    <td class="{{ $s['hadir'] > 0 ? 'bg-green' : '' }}">{{ $s['hadir'] }}</td>
                    <td class="{{ $s['izin'] > 0 ? 'bg-blue' : '' }}">{{ $s['izin'] }}</td>
                    <td class="{{ $s['sakit'] > 0 ? 'bg-yellow' : '' }}">{{ $s['sakit'] }}</td>
                    <td class="{{ $s['bolos'] > 0 ? 'bg-red' : '' }}">{{ $s['bolos'] }}</td>
                    <td>{{ $s['menit_telat'] > 0 ? $s['menit_telat'] : '-' }}</td>
                    <td style="font-weight: bold;">{{ $s['persentase'] }}%</td>
                    <td style="font-weight: bold; color: #b91c1c;">{{ $s['persentase_bolos'] }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TANDA TANGAN -->
    <div class="footer">
        <div class="signature-box">
            <p>
                Cianjur, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM Y') }}<br>
                Kepala Sekolah,
            </p>
            <div class="signature-name">
                (..........................)
            </div>
            <div class="signature-nip">
                NIP. ..........................
            </div>
        </div>
    </div>

</body>
</html>
