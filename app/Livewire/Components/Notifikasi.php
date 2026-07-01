<?php

namespace App\Livewire\Components;

use App\Models\LogAktivitas;
use Illuminate\Support\Collection;
use Livewire\Component;

class Notifikasi extends Component
{
    public bool $open = false;

    // Label & style per jenis aksi, biar tampil rapi di dropdown
    protected array $mapAksi = [
        'create'     => ['label' => 'menambahkan',  'badge' => 'valdo-badge-green'],
        'update'     => ['label' => 'memperbarui',  'badge' => 'valdo-badge-blue'],
        'delete'     => ['label' => 'menghapus',    'badge' => 'valdo-badge-red'],
        'verify'     => ['label' => 'memverifikasi', 'badge' => 'valdo-badge-purple'],
        'send_token' => ['label' => 'mengirim link evaluasi ke', 'badge' => 'valdo-badge-cyan'],
    ];

    // Label tabel target biar tidak nampilin nama tabel mentah
    protected array $mapTabel = [
        'karyawan'          => 'karyawan',
        'klien'             => 'klien',
        'penempatans'       => 'penempatan',
        'evaluasi'          => 'evaluasi',
        'kontrak_karyawan'  => 'kontrak',
        'kriteria_penilaians' => 'kriteria penilaian',
    ];

    public function toggle(): void
    {
        $this->open = !$this->open;
    }

    public function tutup(): void
    {
        $this->open = false;
    }

    public function getDaftarNotifikasiProperty(): Collection
    {
        return LogAktivitas::query()
            ->with('user')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(function (LogAktivitas $log) {
                $aksi   = $this->mapAksi[$log->aksi] ?? ['label' => $log->aksi, 'badge' => 'valdo-badge-muted'];
                $tabel  = $this->mapTabel[$log->tabel_target] ?? $log->tabel_target;
                $nama   = $log->user?->name ?? 'Sistem';

                $deskripsi = trim("{$nama} {$aksi['label']} " . ($tabel ? "data {$tabel}" : ''));
                if ($log->id_target) {
                    $deskripsi .= " #{$log->id_target}";
                }

                return [
                    'id'       => $log->id_log,
                    'deskripsi' => $deskripsi,
                    'badge'    => $aksi['badge'],
                    'aksi'     => $log->aksi,
                    'waktu'    => $log->created_at,
                ];
            });
    }

    public function getJumlahNotifikasiProperty(): int
    {
        // Anggap "baru" = aktivitas dalam 24 jam terakhir
        return LogAktivitas::query()->where('created_at', '>=', now()->subDay())->count();
    }

    public function render()
    {
        return view('livewire.components.notifikasi');
    }
}
