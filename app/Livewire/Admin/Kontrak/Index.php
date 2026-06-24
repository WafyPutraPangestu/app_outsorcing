<?php

namespace App\Livewire\Admin\Kontrak;

use App\Models\Karyawan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = ''; // aktif | hampir_habis | sudah_habis | belum_ada_kontrak

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingFilterStatus(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Karyawan::with(['kontrakAktif'])
            ->where('status_karyawan', 'aktif')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('nama_karyawan', 'like', "%{$this->search}%")
                    ->orWhere('nik', 'like', "%{$this->search}%")
                    ->orWhere('posisi', 'like', "%{$this->search}%")
            );

        // Filter berdasarkan status kontrak
        $query->when(
            $this->filterStatus === 'belum_ada_kontrak',
            fn($q) =>
            $q->whereDoesntHave('kontrak', fn($k) => $k->where('status', 'aktif'))
        );

        $query->when(
            $this->filterStatus === 'aktif',
            fn($q) =>
            $q->whereHas(
                'kontrakAktif',
                fn($k) =>
                $k->whereRaw('DATEDIFF(tanggal_selesai, NOW()) > 30')
            )
        );

        $query->when(
            $this->filterStatus === 'hampir_habis',
            fn($q) =>
            $q->whereHas(
                'kontrakAktif',
                fn($k) =>
                $k->whereRaw('DATEDIFF(tanggal_selesai, NOW()) BETWEEN 0 AND 30')
            )
        );

        $query->when(
            $this->filterStatus === 'sudah_habis',
            fn($q) =>
            $q->whereHas(
                'kontrak',
                fn($k) =>
                $k->where('status', 'aktif')->whereRaw('tanggal_selesai < NOW()')
            )
        );

        $karyawanList = $query->orderBy('nama_karyawan')->paginate(10);

        // Hitung summary cards
        $allKaryawan = Karyawan::with('kontrakAktif')->where('status_karyawan', 'aktif')->get();

        $summary = [
            'total'             => $allKaryawan->count(),
            'aktif'             => $allKaryawan->filter(fn($k) => $k->kontrakAktif && $k->kontrakAktif->sisaHari() > 30)->count(),
            'hampir_habis'      => $allKaryawan->filter(fn($k) => $k->kontrakAktif && $k->kontrakAktif->hampirHabis())->count(),
            'sudah_habis'       => $allKaryawan->filter(fn($k) => $k->kontrakAktif && $k->kontrakAktif->sudahHabis())->count(),
            'belum_ada_kontrak' => $allKaryawan->filter(fn($k) => !$k->kontrakAktif)->count(),
        ];

        return view('livewire.admin.kontrak.index', compact('karyawanList', 'summary'));
    }
}
