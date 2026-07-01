<div>
    {{-- HEADER --}}
    <div class="flex items-start justify-between mb-7 flex-wrap gap-4">
        <div>
            <p class="valdo-text-label mb-1">Manajemen</p>
            <h1 class="valdo-heading-lg">Monitor Evaluasi & Kinerja</h1>
            <p class="valdo-text-muted mt-1">Pantau tren, kinerja, dan ambil keputusan kontrak berdasarkan data evaluasi
                terverifikasi</p>
        </div>
    </div>

    {{-- TABS --}}
    <div class="valdo-tabs mb-6" style="width:fit-content;">
        @foreach ([
        'overview' => 'Overview',
        'tren' => 'Tren & Ranking',
        'riwayat' => 'Riwayat Verifikasi',
        'rekomendasi' => 'Rekomendasi Kontrak',
    ] as $key => $label)
            <button wire:click="$set('tab', '{{ $key }}')" class="valdo-tab {{ $tab === $key ? 'active' : '' }}"
                style="padding:8px 18px;">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- ══════════════ TAB: OVERVIEW ══════════════ --}}
    @if ($tab === 'overview')
        @php $s = $this->statsOverview; @endphp

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">
            <div class="valdo-stat-card">
                <div class="valdo-stat-card-icon blue">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M3 3v18h18M18 17V9M13 17V5M8 17v-3" />
                    </svg>
                </div>
                <div class="valdo-stat-value">{{ $s['avg_ini'] ?? '—' }}</div>
                <div class="valdo-stat-label">Rata-rata Nilai Bulan Ini</div>
                @if ($s['persen_perubahan'] !== null)
                    <span class="valdo-stat-trend {{ $s['persen_perubahan'] >= 0 ? 'up' : 'down' }}">
                        {{ $s['persen_perubahan'] >= 0 ? '↑' : '↓' }} {{ abs($s['persen_perubahan']) }}% vs bulan lalu
                    </span>
                @endif
            </div>

            <div class="valdo-stat-card">
                <div class="valdo-stat-card-icon cyan">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <div class="valdo-stat-value">{{ $s['total_verified'] }}</div>
                <div class="valdo-stat-label">Terverifikasi Bulan Ini</div>
            </div>

            <div class="valdo-stat-card">
                <div class="valdo-stat-card-icon pink">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="15" y1="9" x2="9" y2="15" />
                        <line x1="9" y1="9" x2="15" y2="15" />
                    </svg>
                </div>
                <div class="valdo-stat-value">{{ $s['total_rejected'] }}</div>
                <div class="valdo-stat-label">Ditolak Bulan Ini</div>
            </div>

            <div class="valdo-stat-card">
                <div class="valdo-stat-card-icon purple">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </div>
                <div class="valdo-stat-value">{{ $s['total_pending_admin'] }}</div>
                <div class="valdo-stat-label">Masih Menunggu Admin</div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="valdo-card valdo-card-glow-purple">
                <div class="valdo-card-header" style="border:none;margin-bottom:8px;padding-bottom:0;">
                    <span class="valdo-heading-md">Rekomendasi Putus Kontrak</span>
                </div>
                <div class="valdo-stat-value" style="color:#f87171;font-size:2.5rem;">
                    {{ $s['karyawan_putus_kontrak'] }}</div>
                <p class="valdo-text-muted">karyawan aktif dengan rekomendasi sistem "Putus Kontrak"</p>
            </div>

            <div class="valdo-card valdo-card-glow-blue">
                <div class="valdo-card-header" style="border:none;margin-bottom:8px;padding-bottom:0;">
                    <span class="valdo-heading-md">Kontrak Segera Berakhir</span>
                </div>
                <div class="valdo-stat-value" style="color:var(--color-accent-blue);font-size:2.5rem;">
                    {{ $s['kontrak_hampir_habis'] }}</div>
                <p class="valdo-text-muted">kontrak akan berakhir dalam 30 hari ke depan</p>
            </div>
        </div>
    @endif

    {{-- ══════════════ TAB: TREN & RANKING ══════════════ --}}
    @if ($tab === 'tren')
        {{-- Tren chart (CSS bar, tanpa library) --}}
        <div class="valdo-card mb-6">
            <div class="valdo-card-header">
                <span class="valdo-heading-md">Tren Rata-rata Nilai (6 Periode Terakhir)</span>
            </div>
            @if ($this->trenNilai->isEmpty())
                <p class="valdo-text-muted" style="text-align:center;padding:32px 0;">Belum ada data evaluasi
                    terverifikasi</p>
            @else
                <div style="display:flex;align-items:flex-end;gap:16px;height:180px;padding:0 8px;">
                    @foreach ($this->trenNilai as $t)
                        @php $tinggi = max(($t->rata_rata / 100) * 100, 4); @endphp
                        <div
                            style="flex:1;display:flex;flex-direction:column;align-items:center;gap:8px;height:100%;justify-content:flex-end;">
                            <span
                                style="font-size:0.8rem;font-weight:700;color:#c8ccdc;">{{ round($t->rata_rata, 1) }}</span>
                            <div class="valdo-progress-track {{ $t->rata_rata >= 70 ? 'green' : ($t->rata_rata >= 55 ? 'blue' : 'purple') }}"
                                style="width:100%;height:{{ $tinggi }}%;border-radius:8px 8px 0 0;"></div>
                            <span class="valdo-text-muted" style="font-size:0.72rem;">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $t->periode)->translatedFormat('M Y') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">
            {{-- Top Performer --}}
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <span class="valdo-heading-md">🏆 Top Performer Bulan Ini</span>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @forelse ($this->topKaryawan as $ev)
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--color-base-400);border-radius:10px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="valdo-table-avatar">
                                    {{ strtoupper(substr($ev->penempatan->karyawan->nama_karyawan, 0, 2)) }}</div>
                                <div>
                                    <p style="color:#c8ccdc;font-size:0.85rem;font-weight:500;">
                                        {{ $ev->penempatan->karyawan->nama_karyawan }}</p>
                                    <p class="valdo-text-muted" style="font-size:0.72rem;">
                                        {{ $ev->penempatan->klien->nama_perusahaan }}</p>
                                </div>
                            </div>
                            <span style="font-weight:800;color:#34d399;">{{ $ev->total_nilai_akhir }}</span>
                        </div>
                    @empty
                        <p class="valdo-text-muted" style="text-align:center;padding:16px 0;">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            {{-- Bottom Performer --}}
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <span class="valdo-heading-md">⚠ Perlu Perhatian Bulan Ini</span>
                </div>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    @forelse ($this->bottomKaryawan as $ev)
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--color-base-400);border-radius:10px;">
                            <div style="display:flex;align-items:center;gap:10px;">
                                <div class="valdo-table-avatar">
                                    {{ strtoupper(substr($ev->penempatan->karyawan->nama_karyawan, 0, 2)) }}</div>
                                <div>
                                    <p style="color:#c8ccdc;font-size:0.85rem;font-weight:500;">
                                        {{ $ev->penempatan->karyawan->nama_karyawan }}</p>
                                    <p class="valdo-text-muted" style="font-size:0.72rem;">
                                        {{ $ev->penempatan->klien->nama_perusahaan }}</p>
                                </div>
                            </div>
                            <span
                                style="font-weight:800;color:{{ $ev->total_nilai_akhir < 55 ? '#f87171' : '#f59e0b' }};">{{ $ev->total_nilai_akhir }}</span>
                        </div>
                    @empty
                        <p class="valdo-text-muted" style="text-align:center;padding:16px 0;">Belum ada data</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Karyawan perlu perhatian khusus (nilai turun / rendah, semua periode) --}}
        <div class="valdo-card">
            <div class="valdo-card-header">
                <span class="valdo-heading-md">Karyawan dengan Nilai Menurun atau Rendah</span>
            </div>
            <div style="display:flex;flex-direction:column;gap:8px;">
                @forelse ($this->karyawanPerluPerhatian as $x)
                    <div
                        style="display:flex;align-items:center;justify-content:space-between;padding:10px 12px;background:var(--color-base-400);border-radius:10px;">
                        <div>
                            <p style="color:#c8ccdc;font-size:0.85rem;font-weight:500;">
                                {{ $x->evaluasi->penempatan->karyawan->nama_karyawan }}
                                <span class="valdo-text-muted" style="font-size:0.75rem;">—
                                    {{ $x->evaluasi->penempatan->klien->nama_perusahaan }}</span>
                            </p>
                            <div style="display:flex;gap:6px;margin-top:4px;">
                                @if ($x->rendah)
                                    <span class="valdo-badge valdo-badge-red">Nilai Rendah</span>
                                @endif
                                @if ($x->turun)
                                    <span class="valdo-badge valdo-badge-pink">Menurun dari
                                        {{ $x->sebelumnya->total_nilai_akhir }}</span>
                                @endif
                            </div>
                        </div>
                        <span style="font-weight:800;color:#f87171;">{{ $x->evaluasi->total_nilai_akhir }}</span>
                    </div>
                @empty
                    <p class="valdo-text-muted" style="text-align:center;padding:16px 0;">Tidak ada yang perlu
                        perhatian khusus 🎉</p>
                @endforelse
            </div>
        </div>
    @endif

    {{-- ══════════════ TAB: RIWAYAT (READ-ONLY) ══════════════ --}}
    @if ($tab === 'riwayat')
        <div class="valdo-table-wrapper">
            <div
                style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);display:flex;flex-wrap:wrap;gap:12px;">
                <div class="valdo-search" style="max-width:240px;flex:1;min-width:180px;">
                    <svg class="valdo-search-icon" width="13" height="13" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input wire:model.live.debounce.300ms="riwayatSearch" type="text" class="valdo-search-input"
                        placeholder="Cari karyawan...">
                </div>
                <div class="valdo-select-wrapper">
                    <select wire:model.live="riwayatStatus" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;">
                        <option value="">Semua Status</option>
                        <option value="verified">✓ Verified</option>
                        <option value="rejected">✕ Rejected</option>
                    </select>
                </div>
                <div class="valdo-select-wrapper">
                    <select wire:model.live="riwayatPeriode" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;">
                        <option value="">Semua Periode</option>
                        @foreach ($this->opsiPeriodeRiwayat as $p)
                            <option value="{{ $p }}">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="valdo-select-wrapper">
                    <select wire:model.live="riwayatAdmin" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;">
                        <option value="">Semua Admin</option>
                        @foreach ($this->opsiAdmin as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <table class="valdo-table" style="min-width:900px;">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Klien</th>
                        <th>Periode</th>
                        <th>Nilai Akhir</th>
                        <th>Status</th>
                        <th>Diverifikasi Admin</th>
                        <th>Tgl Verifikasi</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->riwayat as $ev)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="valdo-table-avatar">
                                        {{ strtoupper(substr($ev->penempatan->karyawan->nama_karyawan, 0, 2)) }}</div>
                                    <div>
                                        <p style="color:#c8ccdc;font-weight:500;font-size:0.875rem;">
                                            {{ $ev->penempatan->karyawan->nama_karyawan }}</p>
                                        <p class="valdo-text-mono" style="font-size:0.72rem;">
                                            {{ $ev->penempatan->karyawan->nik }}</p>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#8892b0;font-size:0.85rem;">
                                {{ \Illuminate\Support\Str::limit($ev->penempatan->klien->nama_perusahaan, 25) }}</td>
                            <td><span
                                    class="valdo-badge valdo-badge-blue">{{ \Carbon\Carbon::createFromFormat('Y-m', $ev->periode)->translatedFormat('M Y') }}</span>
                            </td>
                            <td>
                                @if ($ev->total_nilai_akhir !== null)
                                    <span
                                        style="font-weight:800;color:{{ $ev->total_nilai_akhir >= 70 ? '#34d399' : ($ev->total_nilai_akhir >= 55 ? '#f59e0b' : '#f87171') }};">{{ number_format($ev->total_nilai_akhir, 1) }}</span>
                                @else
                                    <span class="valdo-text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if ($ev->status_evaluasi === 'verified')
                                    <span class="valdo-badge valdo-badge-green">✓ Verified</span>
                                @else
                                    <span class="valdo-badge valdo-badge-red">✕ Rejected</span>
                                @endif
                            </td>
                            <td style="color:#8892b0;font-size:0.82rem;">{{ $ev->verifikator?->name ?? '—' }}</td>
                            <td style="color:#6b7190;font-size:0.8rem;">
                                {{ $ev->verified_at?->format('d M Y') ?? '—' }}</td>
                            <td style="max-width:200px;">
                                @if ($ev->catatan_verifikator)
                                    <p style="color:#6b7190;font-size:0.78rem;">
                                        {{ \Illuminate\Support\Str::limit($ev->catatan_verifikator, 60) }}</p>
                                @else
                                    <span class="valdo-text-muted">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;padding:48px 0;">
                                <p class="valdo-text-muted">Belum ada riwayat</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if ($this->riwayat->hasPages())
                <div style="padding:14px 20px;border-top:1px solid rgba(255,255,255,0.04);">
                    {{ $this->riwayat->links() }}
                </div>
            @endif
        </div>
    @endif

    {{-- ══════════════ TAB: REKOMENDASI KONTRAK ══════════════ --}}
    @if ($tab === 'rekomendasi')
        <div class="flex items-center justify-between mb-4">
            <p class="valdo-text-muted">Kontrak yang akan berakhir dalam 30 hari, lengkap dengan histori nilai evaluasi
            </p>
            <button wire:click="exportRekomendasiPdf" wire:loading.attr="disabled" wire:target="exportRekomendasiPdf"
                class="valdo-btn valdo-btn-primary">
                <span wire:loading.remove wire:target="exportRekomendasiPdf">📄 Export PDF</span>
                <span wire:loading wire:target="exportRekomendasiPdf">Menyiapkan...</span>
            </button>
        </div>

        <div class="valdo-table-wrapper">
            <table class="valdo-table">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Klien</th>
                        <th>Berakhir</th>
                        <th>Sisa Hari</th>
                        <th>Rata-rata Nilai</th>
                        <th>Rekomendasi Sistem</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($this->rekomendasiKontrak as $r)
                        <tr>
                            <td>
                                <div style="display:flex;align-items:center;gap:10px;">
                                    <div class="valdo-table-avatar">
                                        {{ strtoupper(substr($r->karyawan->nama_karyawan, 0, 2)) }}</div>
                                    <div>
                                        <p style="color:#c8ccdc;font-weight:500;font-size:0.875rem;">
                                            {{ $r->karyawan->nama_karyawan }}</p>
                                        <p class="valdo-text-mono" style="font-size:0.72rem;">{{ $r->karyawan->nik }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td style="color:#8892b0;font-size:0.85rem;">
                                {{ $r->penempatan?->klien?->nama_perusahaan ?? '—' }}</td>
                            <td style="color:#6b7190;font-size:0.82rem;">
                                {{ $r->kontrak->tanggal_selesai->format('d M Y') }}</td>
                            <td>
                                <span
                                    class="valdo-badge {{ $r->sisa_hari <= 7 ? 'valdo-badge-red' : 'valdo-badge-blue' }}">{{ $r->sisa_hari }}
                                    hari</span>
                            </td>
                            <td>
                                @if ($r->avg_nilai)
                                    <span
                                        style="font-weight:800;color:{{ $r->avg_nilai >= 70 ? '#34d399' : '#f87171' }};">{{ $r->avg_nilai }}</span>
                                @else
                                    <span class="valdo-text-muted">Belum ada data</span>
                                @endif
                            </td>
                            <td>
                                @if ($r->rekomendasi === 'lanjut_kontrak')
                                    <span class="valdo-badge valdo-badge-cyan">Lanjut Kontrak</span>
                                @elseif ($r->rekomendasi === 'putus_kontrak')
                                    <span class="valdo-badge valdo-badge-red">Putus Kontrak</span>
                                @else
                                    <span class="valdo-badge valdo-badge-muted">Belum Dievaluasi</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;padding:48px 0;">
                                <p class="valdo-text-muted">Tidak ada kontrak yang akan berakhir dalam 30 hari</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
