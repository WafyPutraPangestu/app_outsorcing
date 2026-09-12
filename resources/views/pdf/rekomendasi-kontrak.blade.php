<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Rekomendasi Kontrak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            font-weight: bold;
        }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: #fff;
            display: inline-block;
        }
        .bg-red { background-color: #dc3545; }
        .bg-blue { background-color: #0d6efd; }
        .bg-green { background-color: #198754; }
        .bg-cyan { background-color: #0dcaf0; }
        .bg-gray { background-color: #6c757d; }
        .text-green { color: #198754; font-weight: bold; }
        .text-red { color: #dc3545; font-weight: bold; }
        .text-gray { color: #6c757d; }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Rekomendasi Kontrak Karyawan</h1>
        <p>Berakhir Dalam 30 Hari Kedepan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Karyawan</th>
                <th width="20%">Klien</th>
                <th width="15%">Tanggal Berakhir</th>
                <th width="10%">Sisa Hari</th>
                <th width="15%">Rata-rata Nilai</th>
                <th width="15%">Rekomendasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $r)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $r->karyawan->nama_karyawan }}</strong><br>
                        <span class="text-gray">{{ $r->karyawan->nik }}</span>
                    </td>
                    <td>{{ $r->penempatan?->klien?->nama_perusahaan ?? '—' }}</td>
                    <td>{{ $r->kontrak->tanggal_selesai->format('d M Y') }}</td>
                    <td>
                        @if($r->sisa_hari <= 7)
                            <span class="badge bg-red">{{ $r->sisa_hari }} hari</span>
                        @else
                            <span class="badge bg-blue">{{ $r->sisa_hari }} hari</span>
                        @endif
                    </td>
                    <td>
                        @if($r->avg_nilai)
                            @if($r->avg_nilai >= 70)
                                <span class="text-green">{{ $r->avg_nilai }}</span>
                            @else
                                <span class="text-red">{{ $r->avg_nilai }}</span>
                            @endif
                        @else
                            <span class="text-gray">Belum ada data</span>
                        @endif
                    </td>
                    <td>
                        @if($r->rekomendasi === 'lanjut_kontrak')
                            <span class="badge bg-cyan">Lanjut Kontrak</span>
                        @elseif($r->rekomendasi === 'putus_kontrak')
                            <span class="badge bg-red">Putus Kontrak</span>
                        @else
                            <span class="badge bg-gray">Belum Dievaluasi</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center;">Tidak ada kontrak yang akan berakhir dalam 30 hari</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: {{ $dicetakOleh }}</p>
        <p>Tanggal Cetak: {{ $tanggal }}</p>
    </div>
</body>
</html>
