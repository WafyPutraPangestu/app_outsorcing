<!DOCTYPE html>
<html>

<head>
    <title>Evaluasi Kinerja Karyawan</title>
</head>

<body
    style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9fb; padding: 20px;">

    <div
        style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 10px; border-top: 5px solid #4f8ef7; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">

        <h2 style="color: #11131f;">Halo, Tim HRD {{ $tokenData->evaluasi->penempatan->klien->nama_perusahaan }}</h2>

        <p>Sistem PT Valdo mengundang Anda untuk mengisi evaluasi kinerja bulanan (Periode:
            <strong>{{ $tokenData->evaluasi->periode }}</strong>) untuk karyawan kami yang ditempatkan di perusahaan
            Anda:</p>

        <div style="background-color: #f3f6fc; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 0 0 5px 0;"><strong>Nama Karyawan:</strong>
                {{ $tokenData->evaluasi->penempatan->karyawan->nama_karyawan }}</p>
            <p style="margin: 0;"><strong>Posisi:</strong> {{ $tokenData->evaluasi->penempatan->karyawan->posisi }}</p>
        </div>

        <p>Silakan klik tombol di bawah ini untuk mengisi form evaluasi. Tautan ini bersifat rahasia, <strong>hanya bisa
                diisi satu kali</strong>, dan akan hangus pada {{ $tokenData->expired_at->format('d M Y H:i') }}.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}"
                style="display: inline-block; padding: 12px 25px; background-color: #4f8ef7; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: bold;">Isi
                Form Evaluasi</a>
        </div>

        <p style="font-size: 0.9em; color: #666;">Jika tombol tidak berfungsi, salin dan tempel tautan berikut ke browser
            Anda:<br>
            <a href="{{ $url }}" style="color: #4f8ef7;">{{ $url }}</a>
        </p>

        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

        <p style="font-size: 0.85em; color: #888;">Email ini dibuat otomatis oleh Sistem PT Valdo. Mohon tidak membalas
            email ini.</p>
    </div>

</body>

</html>
