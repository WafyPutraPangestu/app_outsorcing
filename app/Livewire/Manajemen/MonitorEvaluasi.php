<?php

namespace App\Livewire\Manajemen;

use App\Models\Evaluasi;
use App\Models\kontrak_karyawan as KontrakKaryawan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Monitor Evaluasi & Kinerja - Valdo System')]
class MonitorEvaluasi extends Component
{
    use WithPagination;

    #[Url]
    public string $tab = 'overview'; // overview | tren | riwayat | rekomendasi

    // Filter Riwayat
    public string $riwayatSearch  = '';
    public string $riwayatStatus  = '';
    public string $riwayatPeriode = '';
    public string $riwayatAdmin   = '';

    public function mount(): void
    {
        abort_unless(Auth::user()?->isManajemen(), 403, 'Halaman ini khusus untuk Manajemen.');
    }

    // ─────────────────────────────────────────────────────────
    // OVERVIEW / STATS
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 120)]
    public function statsOverview(): array
    {
        $periodeIni  = now()->format('Y-m');
        $periodeLalu = now()->subMonth()->format('Y-m');

        $avgIni  = DB::table('evaluasi')->where('status_evaluasi', 'verified')->where('periode', $periodeIni)->avg('total_nilai_akhir');
        $avgLalu = DB::table('evaluasi')->where('status_evaluasi', 'verified')->where('periode', $periodeLalu)->avg('total_nilai_akhir');

        $persenPerubahan = ($avgLalu && $avgLalu > 0)
            ? round((($avgIni - $avgLalu) / $avgLalu) * 100, 1)
            : null;

        return [
            'avg_ini'              => $avgIni ? round($avgIni, 1) : null,
            'avg_lalu'             => $avgLalu ? round($avgLalu, 1) : null,
            'persen_perubahan'     => $persenPerubahan,
            'total_verified'       => DB::table('evaluasi')->where('status_evaluasi', 'verified')->where('periode', $periodeIni)->count(),
            'total_rejected'       => DB::table('evaluasi')->where('status_evaluasi', 'rejected')->where('periode', $periodeIni)->count(),
            'total_pending_admin'  => DB::table('evaluasi')->where('status_evaluasi', 'menunggu_verifikasi')->count(),
            'karyawan_putus_kontrak' => DB::table('penempatans')->where('rekomendasi_sistem', 'putus_kontrak')->where('status_aktif', true)->count(),
            'kontrak_hampir_habis' => DB::table('kontrak_karyawan')
                ->where('status', 'aktif')
                ->whereDate('tanggal_selesai', '>=', now())
                ->whereDate('tanggal_selesai', '<=', now()->addDays(30))
                ->count(),
        ];
    }

    // ─────────────────────────────────────────────────────────
    // TREN NILAI (6 periode terakhir yang punya evaluasi verified)
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 300)]
    public function trenNilai()
    {
        return DB::table('evaluasi')
            ->where('status_evaluasi', 'verified')
            ->select('periode', DB::raw('AVG(total_nilai_akhir) as rata_rata'), DB::raw('COUNT(*) as jumlah'))
            ->groupBy('periode')
            ->orderByDesc('periode')
            ->limit(6)
            ->get()
            ->sortBy('periode')
            ->values();
    }

    // ─────────────────────────────────────────────────────────
    // RANKING: Top & Bottom performer periode berjalan
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 120)]
    public function topKaryawan()
    {
        return Evaluasi::with(['penempatan.karyawan', 'penempatan.klien'])
            ->where('status_evaluasi', 'verified')
            ->where('periode', now()->format('Y-m'))
            ->orderByDesc('total_nilai_akhir')
            ->limit(5)
            ->get();
    }

    #[Computed(cache: true, seconds: 120)]
    public function bottomKaryawan()
    {
        return Evaluasi::with(['penempatan.karyawan', 'penempatan.klien'])
            ->where('status_evaluasi', 'verified')
            ->where('periode', now()->format('Y-m'))
            ->orderBy('total_nilai_akhir')
            ->limit(5)
            ->get();
    }

    // ─────────────────────────────────────────────────────────
    // KARYAWAN PERLU PERHATIAN (nilai rendah / turun dari periode sebelumnya)
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 180)]
    public function karyawanPerluPerhatian()
    {
        return Evaluasi::query()
            ->where('status_evaluasi', 'verified')
            ->with(['penempatan.karyawan', 'penempatan.klien'])
            ->orderByDesc('periode')
            ->get()
            ->groupBy('id_penempatan')
            ->map(function ($grup) {
                $terbaru     = $grup->first();
                $sebelumnya  = $grup->get(1);
                $turun       = $sebelumnya && $terbaru->total_nilai_akhir < $sebelumnya->total_nilai_akhir;
                $rendah      = $terbaru->total_nilai_akhir < 55;

                return (object) [
                    'evaluasi'    => $terbaru,
                    'sebelumnya'  => $sebelumnya,
                    'turun'       => $turun,
                    'rendah'      => $rendah,
                ];
            })
            ->filter(fn($x) => $x->turun || $x->rendah)
            ->take(10)
            ->values();
    }

    // ─────────────────────────────────────────────────────────
    // RIWAYAT (read-only, dengan filter siapa Admin yang verifikasi)
    // ─────────────────────────────────────────────────────────
    #[Computed]
    public function riwayat()
    {
        return Evaluasi::query()
            ->with(['penempatan.karyawan', 'penempatan.klien', 'verifikator:id,name'])
            ->whereIn('status_evaluasi', ['verified', 'rejected'])
            ->when($this->riwayatSearch, function ($q) {
                $q->whereHas('penempatan.karyawan', fn($q2) => $q2
                    ->where('nama_karyawan', 'like', '%' . $this->riwayatSearch . '%')
                    ->orWhere('nik', 'like', '%' . $this->riwayatSearch . '%'));
            })
            ->when($this->riwayatStatus, fn($q) => $q->where('status_evaluasi', $this->riwayatStatus))
            ->when($this->riwayatPeriode, fn($q) => $q->where('periode', $this->riwayatPeriode))
            ->when($this->riwayatAdmin, fn($q) => $q->where('id_user_verifikator', $this->riwayatAdmin))
            ->latest('verified_at')
            ->paginate(15);
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

    #[Computed(cache: true, seconds: 300)]
    public function opsiAdmin()
    {
        return User::query()->where('role', 'admin')
            ->whereIn('id', DB::table('evaluasi')->whereNotNull('id_user_verifikator')->distinct()->pluck('id_user_verifikator'))
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    // ─────────────────────────────────────────────────────────
    // REKOMENDASI KONTRAK (kontrak hampir habis + histori nilai)
    // ─────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 120)]
    public function rekomendasiKontrak()
    {
        return KontrakKaryawan::query()
            ->where('status', 'aktif')
            ->whereDate('tanggal_selesai', '>=', now())
            ->whereDate('tanggal_selesai', '<=', now()->addDays(30))
            ->with(['karyawan.penempatan' => fn($q) => $q->where('status_aktif', true)->with('klien')])
            ->orderBy('tanggal_selesai')
            ->get()
            ->map(function (KontrakKaryawan $kontrak) {
                $penempatan = $kontrak->karyawan->penempatan->first();

                $avgNilai = $penempatan
                    ? DB::table('evaluasi')
                    ->where('id_penempatan', $penempatan->id_penempatan)
                    ->where('status_evaluasi', 'verified')
                    ->avg('total_nilai_akhir')
                    : null;

                return (object) [
                    'kontrak'     => $kontrak,
                    'karyawan'    => $kontrak->karyawan,
                    'penempatan'  => $penempatan,
                    'avg_nilai'   => $avgNilai ? round($avgNilai, 1) : null,
                    'rekomendasi' => $penempatan->rekomendasi_sistem ?? 'belum_dievaluasi',
                    'sisa_hari'   => (int) now()->diffInDays($kontrak->tanggal_selesai, false),
                ];
            });
    }

    // ─────────────────────────────────────────────────────────
    // EXPORT PDF
    // ─────────────────────────────────────────────────────────
    public function exportRekomendasiPdf()
    {
        $data = $this->rekomendasiKontrak;

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.rekomendasi-kontrak', [
            'data'       => $data,
            'tanggal'    => now()->translatedFormat('d F Y'),
            'dicetakOleh' => Auth::user()->name,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'rekomendasi-kontrak-' . now()->format('Ymd-His') . '.pdf'
        );
    }

    // ─────────────────────────────────────────────────────────
    // WATCHERS
    // ─────────────────────────────────────────────────────────
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
    public function updatedRiwayatAdmin(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.manajemen.monitor-evaluasi');
    }
}
