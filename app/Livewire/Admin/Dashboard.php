<?php

namespace App\Livewire\Admin;

use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Penempatan;
use App\Models\Evaluasi;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Dashboard Admin - Valdo System')]
class Dashboard extends Component
{
    public function render()
    {
        // 1. Mengambil Angka Statistik (Sangat cepat karena menggunakan agregat SQL)
        $stats = [
            'karyawan_aktif' => Karyawan::query()->where('status_karyawan', 'aktif')->count(),
            'total_klien'    => Klien::count('*'),
            'kontrak_aktif'  => Penempatan::query()->where('status_aktif', true)->count(),
            'perlu_verifikasi' => Evaluasi::query()->where('status_evaluasi', 'menunggu_verifikasi')->count(),
        ];

        $kontrakHampirHabis = Penempatan::query()
            ->with(['karyawan:id_karyawan,nama_karyawan,posisi', 'klien:id_klien,nama_perusahaan'])
            ->where('status_aktif', true)
            ->whereNotNull('tanggal_selesai')
            ->where('tanggal_selesai', '<=', now()->addDays(30))
            ->orderBy('tanggal_selesai', 'asc')
            ->take(5)
            ->get();

        // 3. Mengambil 5 Evaluasi Terbaru yang masuk
        $evaluasiTerbaru = Evaluasi::query()
            ->with(['penempatan.karyawan:id_karyawan,nama_karyawan', 'penempatan.klien:id_klien,nama_perusahaan'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'kontrakHampirHabis' => $kontrakHampirHabis,
            'evaluasiTerbaru' => $evaluasiTerbaru,
        ]);
    }
}
