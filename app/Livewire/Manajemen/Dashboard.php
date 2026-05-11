<?php

namespace App\Livewire\Manajemen;

use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Penempatan;
use App\Models\Evaluasi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

#[Title('Dashboard Manajemen - Valdo System')]
class Dashboard extends Component
{
    // ── State ──────────────────────────────────────────────────
    public int $tahun;
    public int $tahunSebelumnya;

    // Untuk filter leaderboard
    public string $leaderboardPeriode = 'semua'; // semua | tahun_ini | 6_bulan

    // ── Boot ───────────────────────────────────────────────────
    public function mount(): void
    {
        $this->tahun = Carbon::now()->year;
        $this->tahunSebelumnya = $this->tahun - 1;
    }

    // ─────────────────────────────────────────────────────────────
    // 1. STAT CARDS UTAMA — satu query agregat per tabel, cepat
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 120)]
    public function statsUtama(): array
    {
        // Karyawan
        $karyawan = DB::table('karyawan')
            ->whereNull('deleted_at')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status_karyawan = "aktif" THEN 1 ELSE 0 END) as aktif
            ')
            ->first();

        // Klien
        $klienTotal = DB::table('klien')->whereNull('deleted_at')->count();

        // Penempatan aktif sekarang
        $penempatanAktif = DB::table('penempatans')
            ->where('status_aktif', true)
            ->count();

        // Evaluasi bulan ini
        $periodeIni = Carbon::now()->format('Y-m');
        $evaluasiBulanIni = DB::table('evaluasi')
            ->where('periode', $periodeIni)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status_evaluasi = "verified" THEN 1 ELSE 0 END) as verified,
                SUM(CASE WHEN status_evaluasi = "menunggu_klien" THEN 1 ELSE 0 END) as menunggu_klien,
                SUM(CASE WHEN status_evaluasi = "menunggu_verifikasi" THEN 1 ELSE 0 END) as menunggu_verifikasi
            ')
            ->first();

        return [
            'total_karyawan'          => $karyawan->total ?? 0,
            'karyawan_aktif'          => $karyawan->aktif ?? 0,
            'total_klien'             => $klienTotal,
            'penempatan_aktif'        => $penempatanAktif,
            'evaluasi_bulan_ini'      => $evaluasiBulanIni->total ?? 0,
            'evaluasi_verified'       => $evaluasiBulanIni->verified ?? 0,
            'evaluasi_menunggu_klien' => $evaluasiBulanIni->menunggu_klien ?? 0,
            'evaluasi_menunggu_ver'   => $evaluasiBulanIni->menunggu_verifikasi ?? 0,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // 2. ANALITIK YEAR-ON-YEAR — 12 bulan x 2 tahun, satu query
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 300)]
    public function analitikYoY(): array
    {
        // Rata-rata nilai per bulan untuk 2 tahun terakhir
        $data = DB::table('evaluasi')
            ->where('status_evaluasi', 'verified')
            ->whereIn(DB::raw('YEAR(verified_at)'), [$this->tahunSebelumnya, $this->tahun])
            ->selectRaw('
                YEAR(verified_at) as tahun,
                MONTH(verified_at) as bulan,
                AVG(total_nilai_akhir) as rata_nilai,
                COUNT(*) as jumlah_evaluasi
            ')
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get()
            ->groupBy('tahun');

        $bulanLabel = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'];

        $tahunIniData     = array_fill(1, 12, null);
        $tahunLaluData    = array_fill(1, 12, null);
        $jmlhIniData      = array_fill(1, 12, 0);
        $jmlhLaluData     = array_fill(1, 12, 0);

        foreach (($data[$this->tahun] ?? []) as $row) {
            $tahunIniData[$row->bulan]  = round($row->rata_nilai, 1);
            $jmlhIniData[$row->bulan]   = $row->jumlah_evaluasi;
        }
        foreach (($data[$this->tahunSebelumnya] ?? []) as $row) {
            $tahunLaluData[$row->bulan] = round($row->rata_nilai, 1);
            $jmlhLaluData[$row->bulan]  = $row->jumlah_evaluasi;
        }

        $avgIni  = array_filter($tahunIniData) ? round(array_sum(array_filter($tahunIniData)) / count(array_filter($tahunIniData)), 1) : 0;
        $avgLalu = array_filter($tahunLaluData) ? round(array_sum(array_filter($tahunLaluData)) / count(array_filter($tahunLaluData)), 1) : 0;

        return [
            'labels'           => $bulanLabel,
            'tahun_ini'        => array_values($tahunIniData),
            'tahun_lalu'       => array_values($tahunLaluData),
            'jmlh_ini'         => array_values($jmlhIniData),
            'jmlh_lalu'        => array_values($jmlhLaluData),
            'avg_ini'          => $avgIni,
            'avg_lalu'         => $avgLalu,
            'delta_persen'     => $avgLalu > 0 ? round((($avgIni - $avgLalu) / $avgLalu) * 100, 1) : 0,
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // 3. CONTRACT DECISION HUB — karyawan kontrak mau berakhir
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 180)]
    public function kontrakMauBerakhir(): \Illuminate\Support\Collection
    {
        $standarNilai = 70.0; // bisa dijadikan config
        $batasHari    = 60;   // tampilkan jika sisa <= 60 hari

        return DB::table('penempatans as p')
            ->join('karyawan as k', 'k.id_karyawan', '=', 'p.id_karyawan')
            ->join('klien as kl', 'kl.id_klien', '=', 'p.id_klien')
            ->leftJoin(
                DB::raw('(
                    SELECT id_penempatan,
                           AVG(total_nilai_akhir) as avg_nilai,
                           COUNT(*) as total_evaluasi
                    FROM evaluasi
                    WHERE status_evaluasi = "verified"
                    GROUP BY id_penempatan
                ) as ev'),
                'ev.id_penempatan',
                '=',
                'p.id_penempatan'
            )
            ->where('p.status_aktif', true)
            ->whereNotNull('p.tanggal_selesai')
            ->where('p.tanggal_selesai', '<=', Carbon::now()->addDays($batasHari))
            ->where('p.tanggal_selesai', '>=', Carbon::now())
            ->whereNull('k.deleted_at')
            ->whereNull('kl.deleted_at')
            ->select([
                'p.id_penempatan',
                'p.tanggal_selesai',
                'p.rekomendasi_sistem',
                'k.nama_karyawan',
                'k.posisi',
                'k.nik',
                'kl.nama_perusahaan',
                DB::raw('COALESCE(ev.avg_nilai, 0) as avg_nilai'),
                DB::raw('COALESCE(ev.total_evaluasi, 0) as total_evaluasi'),
                DB::raw('DATEDIFF(p.tanggal_selesai, NOW()) as sisa_hari'),
            ])
            ->orderBy('sisa_hari')
            ->limit(15)
            ->get()
            ->map(function ($row) use ($standarNilai) {
                $row->rekomendasi = match (true) {
                    $row->total_evaluasi === 0             => 'belum_dievaluasi',
                    $row->avg_nilai >= $standarNilai        => 'lanjut_kontrak',
                    default                                 => 'putus_kontrak',
                };
                $row->avg_nilai_fmt = $row->total_evaluasi > 0
                    ? number_format($row->avg_nilai, 1)
                    : '—';
                return $row;
            });
    }

    // ─────────────────────────────────────────────────────────────
    // 4. DISTRIBUSI PERFORMA (Grade A/B/C/D)
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 300)]
    public function distribusiPerforma(): array
    {
        // Ambil rata-rata nilai akhir per karyawan dari semua evaluasi verified
        $data = DB::table('evaluasi as e')
            ->join('penempatans as p', 'p.id_penempatan', '=', 'e.id_penempatan')
            ->where('e.status_evaluasi', 'verified')
            ->whereNull(DB::raw('(SELECT deleted_at FROM karyawan WHERE id_karyawan = p.id_karyawan)'))
            ->select('p.id_karyawan', DB::raw('AVG(e.total_nilai_akhir) as avg_nilai'))
            ->groupBy('p.id_karyawan')
            ->get();

        $grades = ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0];

        foreach ($data as $row) {
            if ($row->avg_nilai >= 85)     $grades['A']++;
            elseif ($row->avg_nilai >= 70) $grades['B']++;
            elseif ($row->avg_nilai >= 55) $grades['C']++;
            else                           $grades['D']++;
        }

        $total = array_sum($grades);

        return [
            'grades'  => $grades,
            'total'   => $total,
            'persen'  => $total > 0 ? array_map(fn($v) => round($v / $total * 100, 1), $grades) : ['A' => 0, 'B' => 0, 'C' => 0, 'D' => 0],
        ];
    }

    // ─────────────────────────────────────────────────────────────
    // 5. CLIENT WORKFORCE INSIGHTS — performa per klien
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 300)]
    public function insightKlien(): \Illuminate\Support\Collection
    {
        return DB::table('klien as kl')
            ->join('penempatans as p', 'p.id_klien', '=', 'kl.id_klien')
            ->join('evaluasi as e', 'e.id_penempatan', '=', 'p.id_penempatan')
            ->where('e.status_evaluasi', 'verified')
            ->whereNull('kl.deleted_at')
            ->select([
                'kl.id_klien',
                'kl.nama_perusahaan',
                DB::raw('AVG(e.total_nilai_akhir) as avg_nilai'),
                DB::raw('COUNT(DISTINCT p.id_karyawan) as jumlah_karyawan'),
                DB::raw('COUNT(e.id_evaluasi) as total_evaluasi'),
                DB::raw('MIN(e.total_nilai_akhir) as nilai_min'),
                DB::raw('MAX(e.total_nilai_akhir) as nilai_max'),
            ])
            ->groupBy('kl.id_klien', 'kl.nama_perusahaan')
            ->orderByDesc('avg_nilai')
            ->limit(10)
            ->get()
            ->map(fn($r) => (object)[
                ...(array)$r,
                'avg_nilai_fmt' => number_format($r->avg_nilai, 1),
                'grade' => match (true) {
                    $r->avg_nilai >= 85 => 'A',
                    $r->avg_nilai >= 70 => 'B',
                    $r->avg_nilai >= 55 => 'C',
                    default             => 'D',
                },
            ]);
    }

    // ─────────────────────────────────────────────────────────────
    // 6. LEADERBOARD — top performers
    // ─────────────────────────────────────────────────────────────
    #[Computed]
    public function leaderboard(): \Illuminate\Support\Collection
    {
        $query = DB::table('karyawan as k')
            ->join('penempatans as p', 'p.id_karyawan', '=', 'k.id_karyawan')
            ->join('evaluasi as e', 'e.id_penempatan', '=', 'p.id_penempatan')
            ->where('e.status_evaluasi', 'verified')
            ->whereNull('k.deleted_at');

        if ($this->leaderboardPeriode === 'tahun_ini') {
            $query->whereYear('e.verified_at', $this->tahun);
        } elseif ($this->leaderboardPeriode === '6_bulan') {
            $query->where('e.verified_at', '>=', Carbon::now()->subMonths(6));
        }

        return $query
            ->select([
                'k.id_karyawan',
                'k.nama_karyawan',
                'k.posisi',
                'k.nik',
                DB::raw('AVG(e.total_nilai_akhir) as avg_nilai'),
                DB::raw('COUNT(e.id_evaluasi) as total_evaluasi'),
            ])
            ->groupBy('k.id_karyawan', 'k.nama_karyawan', 'k.posisi', 'k.nik')
            ->orderByDesc('avg_nilai')
            ->limit(10)
            ->get()
            ->map(fn($r) => (object)[
                ...(array)$r,
                'avg_nilai_fmt' => number_format($r->avg_nilai, 1),
                'grade' => match (true) {
                    $r->avg_nilai >= 85 => 'A',
                    $r->avg_nilai >= 70 => 'B',
                    $r->avg_nilai >= 55 => 'C',
                    default             => 'D',
                },
            ]);
    }

    // ─────────────────────────────────────────────────────────────
    // 7. STATUS EVALUASI REAL-TIME — monitoring bulanan
    // ─────────────────────────────────────────────────────────────
    #[Computed(cache: true, seconds: 60)]
    public function statusEvaluasiRealtime(): array
    {
        // 6 bulan terakhir
        $bulanList = collect(range(5, 0))->map(fn($i) => Carbon::now()->subMonths($i)->format('Y-m'));

        $data = DB::table('evaluasi')
            ->whereIn('periode', $bulanList)
            ->select([
                'periode',
                'status_evaluasi',
                DB::raw('COUNT(*) as jumlah'),
            ])
            ->groupBy('periode', 'status_evaluasi')
            ->get()
            ->groupBy('periode');

        $result = [];
        foreach ($bulanList as $periode) {
            $rows = $data[$periode] ?? collect();
            $byStatus = $rows->pluck('jumlah', 'status_evaluasi');

            $total    = $rows->sum('jumlah');
            $verified = $byStatus['verified'] ?? 0;
            $menunggu_klien = $byStatus['menunggu_klien'] ?? 0;
            $menunggu_ver   = $byStatus['menunggu_verifikasi'] ?? 0;
            $rejected       = $byStatus['rejected'] ?? 0;

            $result[] = [
                'periode'        => $periode,
                'label'          => Carbon::createFromFormat('Y-m', $periode)->translatedFormat('M Y'),
                'total'          => $total,
                'verified'       => $verified,
                'menunggu_klien' => $menunggu_klien,
                'menunggu_ver'   => $menunggu_ver,
                'rejected'       => $rejected,
                'completion_pct' => $total > 0 ? round($verified / $total * 100) : 0,
            ];
        }

        return $result;
    }

    // ─────────────────────────────────────────────────────────────
    // ACTIONS
    // ─────────────────────────────────────────────────────────────
    public function setLeaderboardPeriode(string $periode): void
    {
        $this->leaderboardPeriode = $periode;
        unset($this->leaderboard); // clear computed cache
    }

    // ─────────────────────────────────────────────────────────────
    // RENDER
    // ─────────────────────────────────────────────────────────────
    public function render()
    {
        return view('livewire.manajemen.dashboard', [
            'statsUtama'             => $this->statsUtama,
            'analitikYoY'            => $this->analitikYoY,
            'kontrakMauBerakhir'     => $this->kontrakMauBerakhir,
            'distribusiPerforma'     => $this->distribusiPerforma,
            'insightKlien'           => $this->insightKlien,
            'leaderboard'            => $this->leaderboard,
            'statusEvaluasiRealtime' => $this->statusEvaluasiRealtime,
        ]);
    }
}
