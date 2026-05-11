<?php

namespace App\Livewire\Manajemen;

use App\Models\Evaluasi;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('Verifikasi Penilaian - Valdo System')]
class Verifikasi extends Component
{
    use WithPagination;

    // ── Tab aktif ─────────────────────────────────────────────
    #[Url]
    public string $tab = 'antrean'; // antrean | riwayat

    // ── Filter Antrean ────────────────────────────────────────
    #[Url(history: true)]
    public string $search = '';
    public string $filterPeriode = '';
    public string $filterKlien   = '';
    public int    $perPage        = 15;

    // ── Filter Riwayat ────────────────────────────────────────
    public string $riwayatSearch  = '';
    public string $riwayatStatus  = ''; // verified | rejected
    public string $riwayatPeriode = '';

    // ── Bulk select ───────────────────────────────────────────
    public array $selected      = [];
    public bool  $selectAll     = false;

    // ── Modal Review ──────────────────────────────────────────
    public bool   $showModal        = false;
    public ?int   $activeEvaluasiId = null;
    public string $catatanVerifikator = '';

    // ── Modal Konfirmasi Aksi ─────────────────────────────────
    public bool   $showKonfirmasi  = false;
    public string $aksiKonfirmasi  = ''; // approve | reject
    public bool   $showBulkKonfirmasi = false;

    // ── Listeners ─────────────────────────────────────────────
    protected $listeners = ['refreshVerifikasi' => '$refresh'];

    // ─────────────────────────────────────────────────────────
    // COMPUTED: Antrean Pending
    // ─────────────────────────────────────────────────────────
    #[Computed]
    public function antrean()
    {
        return Evaluasi::query()
            ->with([
                'penempatan.karyawan:id_karyawan,nama_karyawan,nik,posisi',
                'penempatan.klien:id_klien,nama_perusahaan,email_hrd_klien',
                'detail.kriteria:id_kriteria,nama_kriteria,bobot_nilai',
            ])
            ->where('status_evaluasi', 'menunggu_verifikasi')
            ->when($this->search, function ($q) {
                $q->whereHas(
                    'penempatan.karyawan',
                    fn($q2) =>
                    $q2->where('nama_karyawan', 'like', '%' . $this->search . '%')
                        ->orWhere('nik', 'like', '%' . $this->search . '%')
                );
            })
            ->when($this->filterPeriode, fn($q) => $q->where('periode', $this->filterPeriode))
            ->when(
                $this->filterKlien,
                fn($q) =>
                $q->whereHas(
                    'penempatan.klien',
                    fn($q2) =>
                    $q2->where('id_klien', $this->filterKlien)
                )
            )
            ->latest('tanggal_diisi_klien')
            ->paginate($this->perPage);
    }

    // ─────────────────────────────────────────────────────────
    // COMPUTED: Riwayat
    // ─────────────────────────────────────────────────────────
    #[Computed]
    public function riwayat()
    {
        return Evaluasi::query()
            ->with([
                'penempatan.karyawan:id_karyawan,nama_karyawan,nik,posisi',
                'penempatan.klien:id_klien,nama_perusahaan',
                'verifikator:id,name',
            ])
            ->whereIn('status_evaluasi', ['verified', 'rejected'])
            ->when($this->riwayatSearch, function ($q) {
                $q->whereHas(
                    'penempatan.karyawan',
                    fn($q2) =>
                    $q2->where('nama_karyawan', 'like', '%' . $this->riwayatSearch . '%')
                        ->orWhere('nik', 'like', '%' . $this->riwayatSearch . '%')
                );
            })
            ->when($this->riwayatStatus, fn($q) => $q->where('status_evaluasi', $this->riwayatStatus))
            ->when($this->riwayatPeriode, fn($q) => $q->where('periode', $this->riwayatPeriode))
            ->latest('verified_at')
            ->paginate($this->perPage);
    }

    // ─────────────────────────────────────────────────────────
    // COMPUTED: Data modal (hanya load saat diperlukan)
    // ─────────────────────────────────────────────────────────
    #[Computed]
    public function evaluasiAktif(): ?Evaluasi
    {
        if (!$this->activeEvaluasiId) return null;

        return Evaluasi::with([
            'penempatan.karyawan',
            'penempatan.klien',
            'detail.kriteria',
            'verifikator:id,name',
        ])->find($this->activeEvaluasiId);
    }

    // ─────────────────────────────────────────────────────────
    // COMPUTED: Opsi Filter
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 300)]
    public function opsiKlien()
    {
        return DB::table('klien')
            ->whereNull('deleted_at')
            ->select('id_klien', 'nama_perusahaan')
            ->orderBy('nama_perusahaan')
            ->get();
    }

    #[Computed(cache: true, seconds: 300)]
    public function opsiPeriode()
    {
        return DB::table('evaluasi')
            ->where('status_evaluasi', 'menunggu_verifikasi')
            ->distinct()
            ->orderByDesc('periode')
            ->pluck('periode');
    }

    #[Computed(cache: true, seconds: 300)]
    public function opsiPeriodeRiwayat()
    {
        return DB::table('evaluasi')
            ->whereIn('status_evaluasi', ['verified', 'rejected'])
            ->distinct()
            ->orderByDesc('periode')
            ->pluck('periode');
    }

    // ─────────────────────────────────────────────────────────
    // COMPUTED: Summary stats antrean
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 60)]
    public function statsAntrean(): array
    {
        $data = DB::table('evaluasi')
            ->where('status_evaluasi', 'menunggu_verifikasi')
            ->selectRaw('COUNT(*) as total, MIN(tanggal_diisi_klien) as tertua')
            ->first();

        $bulanIni = DB::table('evaluasi')
            ->where('status_evaluasi', 'menunggu_verifikasi')
            ->where('periode', Carbon::now()->format('Y-m'))
            ->count();

        return [
            'total'    => $data->total ?? 0,
            'bulan_ini' => $bulanIni,
            'tertua'   => $data->tertua ? Carbon::parse($data->tertua)->diffForHumans() : null,
        ];
    }

    // ─────────────────────────────────────────────────────────
    // ACTION: Buka Modal Review
    // ─────────────────────────────────────────────────────────
    public function bukaModal(int $id): void
    {
        $this->activeEvaluasiId   = $id;
        $this->catatanVerifikator = '';
        $this->aksiKonfirmasi     = '';
        $this->showKonfirmasi     = false;
        $this->showModal          = true;
        unset($this->evaluasiAktif);
    }

    public function tutupModal(): void
    {
        $this->showModal          = false;
        $this->activeEvaluasiId   = null;
        $this->catatanVerifikator = '';
        $this->showKonfirmasi     = false;
    }

    // ─────────────────────────────────────────────────────────
    // ACTION: Konfirmasi sebelum approve/reject
    // ─────────────────────────────────────────────────────────
    public function konfirmasiAksi(string $aksi): void
    {
        $this->aksiKonfirmasi = $aksi;
        $this->showKonfirmasi = true;
    }

    public function batalKonfirmasi(): void
    {
        $this->showKonfirmasi = false;
        $this->aksiKonfirmasi = '';
    }

    // ─────────────────────────────────────────────────────────
    // ACTION: Approve Single
    // ─────────────────────────────────────────────────────────
    public function approve(): void
    {
        $this->validate([
            'catatanVerifikator' => 'required|string|min:5|max:500',
        ], [
            'catatanVerifikator.required' => 'Catatan verifikator wajib diisi.',
            'catatanVerifikator.min'      => 'Catatan minimal 5 karakter.',
        ]);

        $evaluasi = Evaluasi::with('detail.kriteria')
            ->findOrFail($this->activeEvaluasiId);

        DB::transaction(function () use ($evaluasi) {
            // Hitung ulang total nilai akhir (weighted average)
            $totalBobot = 0;
            $totalNilai = 0;
            foreach ($evaluasi->detail as $d) {
                $bobot       = $d->kriteria->bobot_nilai ?? 1;
                $totalBobot += $bobot;
                $totalNilai += $d->skor_nilai * $bobot;
            }
            $nilaiAkhir = $totalBobot > 0
                ? round($totalNilai / $totalBobot, 2)
                : ($evaluasi->detail->avg('skor_nilai') ?? 0);

            $dataLama = $evaluasi->toArray();

            $evaluasi->update([
                'status_evaluasi'      => 'verified',
                'id_user_verifikator'  => Auth::id(),
                'catatan_verifikator'  => $this->catatanVerifikator,
                'verified_at'          => now(),
                'total_nilai_akhir'    => $nilaiAkhir,
            ]);

            // Update rekomendasi penempatan
            $this->updateRekomendasiPenempatan($evaluasi->id_penempatan);

            LogAktivitas::catat(
                aksi: 'verify_approve',
                tabelTarget: 'evaluasi',
                idTarget: $evaluasi->id_evaluasi,
                dataLama: $dataLama,
                dataBaru: $evaluasi->fresh()->toArray(),
            );
        });

        $this->tutupModal();
        $this->clearComputedCache();
        session()->flash('toast_success', 'Evaluasi berhasil disetujui dan terverifikasi.');
    }

    // ─────────────────────────────────────────────────────────
    // ACTION: Reject Single
    // ─────────────────────────────────────────────────────────
    public function reject(): void
    {
        $this->validate([
            'catatanVerifikator' => 'required|string|min:10|max:500',
        ], [
            'catatanVerifikator.required' => 'Alasan penolakan wajib diisi.',
            'catatanVerifikator.min'      => 'Alasan penolakan minimal 10 karakter.',
        ]);

        $evaluasi = Evaluasi::findOrFail($this->activeEvaluasiId);
        $dataLama = $evaluasi->toArray();

        DB::transaction(function () use ($evaluasi, $dataLama) {
            $evaluasi->update([
                'status_evaluasi'     => 'rejected',
                'id_user_verifikator' => Auth::id(),
                'catatan_verifikator' => $this->catatanVerifikator,
                'verified_at'         => now(),
            ]);

            LogAktivitas::catat(
                aksi: 'verify_reject',
                tabelTarget: 'evaluasi',
                idTarget: $evaluasi->id_evaluasi,
                dataLama: $dataLama,
                dataBaru: $evaluasi->fresh()->toArray(),
            );
        });

        $this->tutupModal();
        $this->clearComputedCache();
        session()->flash('toast_success', 'Evaluasi telah ditolak. Catatan telah disimpan.');
    }

    // ─────────────────────────────────────────────────────────
    // ACTION: Bulk Approve
    // ─────────────────────────────────────────────────────────
    public function bulkApprove(): void
    {
        if (empty($this->selected)) {
            session()->flash('toast_error', 'Pilih minimal satu evaluasi terlebih dahulu.');
            return;
        }

        $jumlah = count($this->selected);

        DB::transaction(function () {
            $evaluasiList = Evaluasi::with('detail.kriteria')
                ->whereIn('id_evaluasi', $this->selected)
                ->where('status_evaluasi', 'menunggu_verifikasi')
                ->get();

            foreach ($evaluasiList as $evaluasi) {
                // Hitung nilai akhir per item
                $totalBobot = 0;
                $totalNilai = 0;
                foreach ($evaluasi->detail as $d) {
                    $bobot       = $d->kriteria->bobot_nilai ?? 1;
                    $totalBobot += $bobot;
                    $totalNilai += $d->skor_nilai * $bobot;
                }
                $nilaiAkhir = $totalBobot > 0
                    ? round($totalNilai / $totalBobot, 2)
                    : ($evaluasi->detail->avg('skor_nilai') ?? 0);

                $evaluasi->update([
                    'status_evaluasi'     => 'verified',
                    'id_user_verifikator' => Auth::id(),
                    'catatan_verifikator' => 'Disetujui secara massal oleh manajemen.',
                    'verified_at'         => now(),
                    'total_nilai_akhir'   => $nilaiAkhir,
                ]);

                $this->updateRekomendasiPenempatan($evaluasi->id_penempatan);

                LogAktivitas::catat(
                    aksi: 'verify_bulk_approve',
                    tabelTarget: 'evaluasi',
                    idTarget: $evaluasi->id_evaluasi,
                    dataBaru: ['bulk' => true, 'verifikator' => Auth::id()],
                );
            }
        });

        $this->selected         = [];
        $this->selectAll        = false;
        $this->showBulkKonfirmasi = false;
        $this->clearComputedCache();
        session()->flash('toast_success', "{$jumlah} evaluasi berhasil diverifikasi sekaligus.");
    }

    // ─────────────────────────────────────────────────────────
    // HELPER: Update rekomendasi sistem di tabel penempatan
    // ─────────────────────────────────────────────────────────
    private function updateRekomendasiPenempatan(int $idPenempatan): void
    {
        $standar = 70.0;

        $avg = DB::table('evaluasi')
            ->where('id_penempatan', $idPenempatan)
            ->where('status_evaluasi', 'verified')
            ->avg('total_nilai_akhir');

        if ($avg === null) return;

        DB::table('penempatans')
            ->where('id_penempatan', $idPenempatan)
            ->update([
                'rekomendasi_sistem' => $avg >= $standar ? 'lanjut_kontrak' : 'putus_kontrak',
                'updated_at'         => now(),
            ]);
    }

    // ─────────────────────────────────────────────────────────
    // HELPER: Clear semua computed cache agar data segar
    // ─────────────────────────────────────────────────────────
    private function clearComputedCache(): void
    {
        unset(
            $this->antrean,
            $this->riwayat,
            $this->statsAntrean,
            $this->opsiPeriode,
            $this->opsiPeriodeRiwayat,
            $this->evaluasiAktif
        );
        $this->resetPage();
    }

    // ─────────────────────────────────────────────────────────
    // WATCHERS
    // ─────────────────────────────────────────────────────────
    public function updatedSearch(): void
    {
        $this->resetPage();
        $this->selected = [];
    }
    public function updatedFilterPeriode(): void
    {
        $this->resetPage();
        $this->selected = [];
    }
    public function updatedFilterKlien(): void
    {
        $this->resetPage();
        $this->selected = [];
    }
    public function updatedRiwayatSearch(): void
    {
        $this->resetPage();
    }
    public function updatedRiwayatStatus(): void
    {
        $this->resetPage();
    }
    public function updatedRiwayatPeriode(): void
    {
        $this->resetPage();
    }
    public function updatedTab(): void
    {
        $this->resetPage();
        $this->selected = [];
    }

    public function updatedSelectAll(bool $val): void
    {
        if ($val) {
            // Ambil semua id di halaman saat ini
            $this->selected = $this->antrean
                ->pluck('id_evaluasi')
                ->map(fn($id) => (string)$id)
                ->toArray();
        } else {
            $this->selected = [];
        }
    }

    // ─────────────────────────────────────────────────────────
    // RENDER
    // ─────────────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.manajemen.verifikasi', [
            'antrean'           => $this->antrean,
            'riwayat'           => $this->riwayat,
            'evaluasiAktif'     => $this->evaluasiAktif,
            'opsiKlien'         => $this->opsiKlien,
            'opsiPeriode'       => $this->opsiPeriode,
            'opsiPeriodeRiwayat' => $this->opsiPeriodeRiwayat,
            'statsAntrean'      => $this->statsAntrean,
        ]);
    }
}
