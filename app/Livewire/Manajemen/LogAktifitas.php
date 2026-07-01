<?php

namespace App\Livewire\Manajemen;

use App\Models\LogAktivitas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class LogAktifitas extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterAksi = '';
    public string $filterTabel = '';
    public string $filterUser = '';
    public string $tanggalMulai = '';
    public string $tanggalSelesai = '';

    public ?int $selectedLogId = null;
    public bool $showDetail = false;

    protected array $mapAksi = [
        'create'     => ['label' => 'Tambah',       'badge' => 'valdo-badge-green'],
        'update'     => ['label' => 'Update',       'badge' => 'valdo-badge-blue'],
        'delete'     => ['label' => 'Hapus',        'badge' => 'valdo-badge-red'],
        'verify'     => ['label' => 'Verifikasi',   'badge' => 'valdo-badge-purple'],
        'send_token' => ['label' => 'Kirim Token',  'badge' => 'valdo-badge-cyan'],
    ];

    protected array $mapTabel = [
        'karyawan'            => 'Karyawan',
        'klien'               => 'Klien',
        'penempatans'         => 'Penempatan',
        'evaluasi'            => 'Evaluasi',
        'kontrak_karyawan'    => 'Kontrak',
        'kriteria_penilaians' => 'Kriteria Penilaian',
    ];

    public function mount(): void
    {
        abort_unless(Auth::user()?->isManajemen(), 403, 'Halaman ini khusus untuk Manajemen.');
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }
    public function updatingFilterAksi(): void
    {
        $this->resetPage();
    }
    public function updatingFilterTabel(): void
    {
        $this->resetPage();
    }
    public function updatingFilterUser(): void
    {
        $this->resetPage();
    }
    public function updatingTanggalMulai(): void
    {
        $this->resetPage();
    }
    public function updatingTanggalSelesai(): void
    {
        $this->resetPage();
    }

    public function resetFilter(): void
    {
        $this->reset(['search', 'filterAksi', 'filterTabel', 'filterUser', 'tanggalMulai', 'tanggalSelesai']);
        $this->resetPage();
    }

    public function lihatDetail(int $idLog): void
    {
        $this->selectedLogId = $idLog;
        $this->showDetail = true;
    }

    public function tutupDetail(): void
    {
        $this->showDetail = false;
        $this->selectedLogId = null;
    }

    public function getSelectedLogProperty(): ?LogAktivitas
    {
        if (!$this->selectedLogId) {
            return null;
        }

        return LogAktivitas::with('user')->find($this->selectedLogId);
    }

    public function getDaftarUserProperty()
    {
        // Hanya user yang pernah tercatat di log, biar dropdown ga penuh user tak relevan
        return User::whereIn('id', LogAktivitas::query()->distinct()->pluck('id_user'))
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    public function getLogsProperty()
    {
        return LogAktivitas::query()
            ->with('user')
            ->when($this->filterAksi, fn($q) => $q->where('aksi', $this->filterAksi))
            ->when($this->filterTabel, fn($q) => $q->where('tabel_target', $this->filterTabel))
            ->when($this->filterUser, fn($q) => $q->where('id_user', $this->filterUser))
            ->when($this->tanggalMulai, fn($q) => $q->whereDate('created_at', '>=', $this->tanggalMulai))
            ->when($this->tanggalSelesai, fn($q) => $q->whereDate('created_at', '<=', $this->tanggalSelesai))
            ->when($this->search, function ($q) {
                $q->whereHas('user', fn($sub) => $sub->where('name', 'like', "%{$this->search}%"));
            })
            ->latest('created_at')
            ->paginate(15);
    }

    public function labelAksi(string $aksi): array
    {
        return $this->mapAksi[$aksi] ?? ['label' => $aksi, 'badge' => 'valdo-badge-muted'];
    }

    public function labelTabel(?string $tabel): string
    {
        if (!$tabel) {
            return '-';
        }

        return $this->mapTabel[$tabel] ?? $tabel;
    }

    public function render()
    {
        return view('livewire.manajemen.log-aktifitas');
    }
}
