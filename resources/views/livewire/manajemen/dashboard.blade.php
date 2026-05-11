<div x-data="valdoDashboard()" x-init="init()">

    {{-- ══════════════════════════════════════════════════════════
         LIVEWIRE LOADING BAR
    ══════════════════════════════════════════════════════════ --}}
    <div wire:loading.flex class="valdo-wire-loading-bar" style="display:none;"></div>

    {{-- ══════════════════════════════════════════════════════════
         HEADER
    ══════════════════════════════════════════════════════════ --}}
    <div class="flex items-start justify-between mb-8 flex-wrap gap-4">
        <div>
            <p class="valdo-text-label mb-1">Pusat Kendali Strategis</p>
            <h1 class="valdo-heading-lg">Dashboard Manajemen</h1>
            <p class="valdo-text-muted mt-1">
                Pemantauan performa operasional &mdash;
                <span class="valdo-text-mono">{{ now()->translatedFormat('d F Y, H:i') }}</span>
            </p>
        </div>
        <div class="flex items-center gap-3">
            <div
                style="background:var(--color-base-300);border:1px solid rgba(255,255,255,0.05);border-radius:10px;padding:6px 14px;display:flex;align-items:center;gap:8px;box-shadow:var(--neu-shadow-sm);">
                <span class="valdo-text-label">Tahun</span>
                <span
                    style="color:var(--color-accent-blue);font-weight:700;font-size:0.9rem;">{{ $tahun }}</span>
            </div>
            <div
                style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 8px rgba(52,211,153,0.6);animation:valdo-pulse 2s infinite;">
            </div>
            <span class="valdo-text-muted" style="font-size:0.75rem;">Live</span>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 1: STAT CARDS
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-7">

        {{-- Karyawan Aktif --}}
        <div class="valdo-stat-card" style="grid-column: span 1;">
            <div class="valdo-stat-card-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $statsUtama['karyawan_aktif'] }}</div>
            <div class="valdo-stat-label">Karyawan Aktif</div>
            <span class="valdo-stat-trend up" style="margin-top:8px;">
                dari {{ $statsUtama['total_karyawan'] }} total
            </span>
        </div>

        {{-- Penempatan Aktif --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="7" width="20" height="14" rx="2" />
                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $statsUtama['penempatan_aktif'] }}</div>
            <div class="valdo-stat-label">Penempatan Aktif</div>
            <span class="valdo-stat-trend up" style="margin-top:8px;">
                {{ $statsUtama['total_klien'] }} klien aktif
            </span>
        </div>

        {{-- Evaluasi Bulan Ini --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon cyan">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                    <polyline points="14 2 14 8 20 8" />
                    <line x1="16" y1="13" x2="8" y2="13" />
                    <line x1="16" y1="17" x2="8" y2="17" />
                    <polyline points="10 9 9 9 8 9" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $statsUtama['evaluasi_verified'] }}</div>
            <div class="valdo-stat-label">Evaluasi Verified Bulan Ini</div>
            <span class="valdo-stat-trend up" style="margin-top:8px;">
                {{ $statsUtama['evaluasi_bulan_ini'] }} total periode ini
            </span>
        </div>

        {{-- Menunggu Tindakan --}}
        <div class="valdo-stat-card"
            style="border-color: {{ $statsUtama['evaluasi_menunggu_klien'] + $statsUtama['evaluasi_menunggu_ver'] > 0 ? 'rgba(245,158,11,0.2)' : 'rgba(255,255,255,0.05)' }};">
            <div class="valdo-stat-card-icon pink">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <polyline points="12 6 12 12 16 14" />
                </svg>
            </div>
            <div class="valdo-stat-value"
                style="{{ $statsUtama['evaluasi_menunggu_klien'] + $statsUtama['evaluasi_menunggu_ver'] > 0 ? 'color:#f59e0b;' : '' }}">
                {{ $statsUtama['evaluasi_menunggu_klien'] + $statsUtama['evaluasi_menunggu_ver'] }}
            </div>
            <div class="valdo-stat-label">Menunggu Tindakan</div>
            <span class="valdo-stat-trend down" style="margin-top:8px;">
                {{ $statsUtama['evaluasi_menunggu_klien'] }} menunggu klien
            </span>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 2: YoY ANALYTICS + DISTRIBUSI GRADE (2 kolom)
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-7">

        {{-- YOY CHART — span 2 --}}
        <div class="valdo-card xl:col-span-2" style="padding:0;overflow:hidden;">
            <div class="valdo-card-header" style="padding:20px 24px 16px;">
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Analitik Performa Year-on-Year</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;margin-top:2px;">Rata-rata nilai evaluasi per
                        bulan</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span
                            style="width:24px;height:3px;border-radius:2px;background:var(--color-accent-blue);display:inline-block;"></span>
                        <span class="valdo-text-muted" style="font-size:0.75rem;">{{ $tahun }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span
                            style="width:24px;height:3px;border-radius:2px;background:var(--color-accent-purple);display:inline-block;border:none;border-top:2px dashed var(--color-accent-purple);background:none;"></span>
                        <span class="valdo-text-muted" style="font-size:0.75rem;">{{ $tahunSebelumnya }}</span>
                    </div>
                    {{-- Delta Badge --}}
                    @php $delta = $analitikYoY['delta_persen']; @endphp
                    <span class="valdo-badge {{ $delta >= 0 ? 'valdo-badge-cyan' : 'valdo-badge-red' }}">
                        {{ $delta >= 0 ? '▲' : '▼' }} {{ abs($delta) }}%
                    </span>
                </div>
            </div>

            {{-- Avg row --}}
            <div class="flex items-center gap-6 px-6 pb-4 flex-wrap">
                <div>
                    <p class="valdo-text-label" style="margin-bottom:2px;">Rata-rata {{ $tahun }}</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--color-accent-blue);">
                        {{ $analitikYoY['avg_ini'] }}</p>
                </div>
                <div class="valdo-divider-vertical" style="height:36px;"></div>
                <div>
                    <p class="valdo-text-label" style="margin-bottom:2px;">Rata-rata {{ $tahunSebelumnya }}</p>
                    <p style="font-size:1.5rem;font-weight:800;color:var(--color-accent-purple);">
                        {{ $analitikYoY['avg_lalu'] ?: '—' }}</p>
                </div>
            </div>

            {{-- Canvas Chart --}}
            <div style="padding:0 16px 20px;">
                <canvas id="yoyChart" height="200" data-ini="{{ json_encode($analitikYoY['tahun_ini']) }}"
                    data-lalu="{{ json_encode($analitikYoY['tahun_lalu']) }}"
                    data-labels="{{ json_encode($analitikYoY['labels']) }}" data-tahun="{{ $tahun }}"
                    data-tahunlalu="{{ $tahunSebelumnya }}">
                </canvas>
            </div>
        </div>

        {{-- DISTRIBUSI GRADE --}}
        <div class="valdo-card" style="display:flex;flex-direction:column;">
            <div class="valdo-card-header" style="margin-bottom:16px;">
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Distribusi Grade</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;margin-top:2px;">Populasi karyawan per
                        performa</p>
                </div>
            </div>

            <div style="position:relative;width:160px;height:160px;margin:0 auto 20px;">
                <canvas id="gradeChart" data-grades="{{ json_encode(array_values($distribusiPerforma['grades'])) }}"
                    data-persen="{{ json_encode(array_values($distribusiPerforma['persen'])) }}">
                </canvas>
                <div
                    style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
                    <span
                        style="font-size:1.5rem;font-weight:800;color:#e2e5f0;">{{ $distribusiPerforma['total'] }}</span>
                    <span
                        style="font-size:0.7rem;color:#6b7190;text-transform:uppercase;letter-spacing:0.08em;">karyawan</span>
                </div>
            </div>

            {{-- Grade Legend --}}
            @php
                $gradeConfig = [
                    'A' => ['label' => 'Grade A (≥85)', 'color' => '#34d399', 'desc' => 'Istimewa'],
                    'B' => ['label' => 'Grade B (≥70)', 'color' => 'var(--color-accent-cyan)', 'desc' => 'Baik'],
                    'C' => ['label' => 'Grade C (≥55)', 'color' => '#f59e0b', 'desc' => 'Cukup'],
                    'D' => ['label' => 'Grade D (<55)', 'color' => '#f87171', 'desc' => 'Butuh Pembinaan'],
                ];
            @endphp
            <div style="display:flex;flex-direction:column;gap:10px;flex:1;">
                @foreach ($gradeConfig as $key => $cfg)
                    <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;">
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span
                                style="width:10px;height:10px;border-radius:3px;background:{{ $cfg['color'] }};flex-shrink:0;"></span>
                            <div>
                                <p style="font-size:0.78rem;color:#8892b0;font-weight:500;">{{ $cfg['label'] }}</p>
                                <p style="font-size:0.68rem;color:#3d4263;">{{ $cfg['desc'] }}</p>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <span
                                style="font-size:0.9rem;font-weight:700;color:#c8ccdc;">{{ $distribusiPerforma['grades'][$key] }}</span>
                            <span class="valdo-text-muted"
                                style="font-size:0.72rem;margin-left:4px;">({{ $distribusiPerforma['persen'][$key] }}%)</span>
                        </div>
                    </div>
                    @if (!$loop->last)
                        <div class="valdo-divider" style="margin:0;"></div>
                    @endif
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 3: CONTRACT DECISION HUB
    ══════════════════════════════════════════════════════════ --}}
    <div class="valdo-card mb-7" style="padding:0;overflow:hidden;">
        <div class="valdo-card-header" style="padding:20px 24px 16px;">
            <div class="flex items-center gap-3">
                <div
                    style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(245,158,11,0.2),rgba(245,158,11,0.08));color:#f59e0b;display:flex;align-items:center;justify-content:center;box-shadow:var(--neu-shadow-md),0 0 16px rgba(245,158,11,0.15);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                    </svg>
                </div>
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Pusat Keputusan Kontrak</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;">Kontrak berakhir dalam 60 hari ke depan</p>
                </div>
            </div>
            <span class="valdo-badge valdo-badge-pink">{{ $kontrakMauBerakhir->count() }} perlu ditinjau</span>
        </div>

        @if ($kontrakMauBerakhir->isEmpty())
            <div style="padding:48px 24px;text-align:center;">
                <div
                    style="width:48px;height:48px;border-radius:14px;background:var(--color-base-400);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:var(--neu-shadow-md);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="#34d399" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <p style="color:#34d399;font-weight:600;font-size:0.875rem;">Semua kontrak aman</p>
                <p class="valdo-text-muted" style="font-size:0.8rem;margin-top:4px;">Tidak ada kontrak yang berakhir
                    dalam 60 hari ke depan</p>
            </div>
        @else
            <div style="overflow-x:auto;">
                <table class="valdo-table" style="min-width:750px;">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Klien / Lokasi</th>
                            <th>Sisa Hari</th>
                            <th>Tgl Berakhir</th>
                            <th>Skor Rata-rata</th>
                            <th>Total Evaluasi</th>
                            <th style="text-align:center;">Rekomendasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($kontrakMauBerakhir as $row)
                            @php
                                $rekStyle = match ($row->rekomendasi) {
                                    'lanjut_kontrak' => [
                                        'badge' => 'valdo-badge-cyan',
                                        'icon' => '✓',
                                        'text' => 'Lanjut Kontrak',
                                    ],
                                    'putus_kontrak' => [
                                        'badge' => 'valdo-badge-red',
                                        'icon' => '✕',
                                        'text' => 'Putus Kontrak',
                                    ],
                                    default => [
                                        'badge' => 'valdo-badge-muted',
                                        'icon' => '?',
                                        'text' => 'Belum Dievaluasi',
                                    ],
                                };
                                $sisaColor =
                                    $row->sisa_hari <= 14 ? '#f87171' : ($row->sisa_hari <= 30 ? '#f59e0b' : '#c8ccdc');
                                $nilaiColor =
                                    $row->avg_nilai >= 70 ? '#34d399' : ($row->avg_nilai >= 55 ? '#f59e0b' : '#f87171');
                            @endphp
                            <tr class="{{ $row->sisa_hari <= 14 ? 'active' : '' }}">
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="valdo-table-avatar" style="flex-shrink:0;">
                                            {{ strtoupper(substr($row->nama_karyawan, 0, 2)) }}</div>
                                        <div>
                                            <p style="color:#c8ccdc;font-weight:500;font-size:0.875rem;">
                                                {{ $row->nama_karyawan }}</p>
                                            <p class="valdo-text-mono" style="font-size:0.72rem;">{{ $row->nik }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p style="color:#8892b0;font-size:0.85rem;">{{ $row->nama_perusahaan }}</p>
                                    <p style="color:#3d4263;font-size:0.75rem;">{{ $row->posisi }}</p>
                                </td>
                                <td>
                                    <span
                                        style="font-size:1rem;font-weight:800;color:{{ $sisaColor }};">{{ $row->sisa_hari }}</span>
                                    <span style="color:#6b7190;font-size:0.75rem;margin-left:4px;">hari</span>
                                </td>
                                <td style="color:#8892b0;font-size:0.85rem;">
                                    {{ \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y') }}
                                </td>
                                <td>
                                    @if ($row->total_evaluasi > 0)
                                        <span
                                            style="font-size:1rem;font-weight:700;color:{{ $nilaiColor }};">{{ $row->avg_nilai_fmt }}</span>
                                        <span style="color:#3d4263;font-size:0.75rem;">/100</span>
                                        <div class="valdo-progress" style="margin-top:4px;width:80px;height:4px;">
                                            <div class="valdo-progress-track {{ $row->avg_nilai >= 70 ? 'green' : ($row->avg_nilai >= 55 ? 'blue' : 'purple') }}"
                                                style="width:{{ min($row->avg_nilai, 100) }}%"></div>
                                        </div>
                                    @else
                                        <span class="valdo-text-muted">—</span>
                                    @endif
                                </td>
                                <td style="color:#6b7190;font-size:0.85rem;text-align:center;">
                                    {{ $row->total_evaluasi }}</td>
                                <td style="text-align:center;">
                                    <span class="valdo-badge {{ $rekStyle['badge'] }}">
                                        {{ $rekStyle['icon'] }} {{ $rekStyle['text'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 4: CLIENT INSIGHTS + MONITORING EVALUASI
    ══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-7">

        {{-- CLIENT WORKFORCE INSIGHTS --}}
        <div class="valdo-card" style="padding:0;overflow:hidden;">
            <div class="valdo-card-header" style="padding:20px 24px 16px;">
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Insight Klien & Tenaga Kerja</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;">Peringkat klien berdasarkan rata-rata
                        penilaian</p>
                </div>
            </div>

            <div style="padding:0 24px 24px;display:flex;flex-direction:column;gap:10px;">
                @forelse ($insightKlien as $idx => $klien)
                    @php
                        $gradeColor = match ($klien->grade) {
                            'A' => '#34d399',
                            'B' => 'var(--color-accent-cyan)',
                            'C' => '#f59e0b',
                            'D' => '#f87171',
                        };
                        $maxNilai = $insightKlien->max('avg_nilai');
                        $barWidth = $maxNilai > 0 ? ($klien->avg_nilai / $maxNilai) * 100 : 0;
                    @endphp
                    <div style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);transition:all 0.2s ease;"
                        x-on:mouseenter="$el.style.borderColor='rgba(79,142,247,0.2)'"
                        x-on:mouseleave="$el.style.borderColor='rgba(255,255,255,0.05)'">
                        <div
                            style="display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:8px;">
                            <div style="display:flex;align-items:center;gap:10px;min-width:0;">
                                <span
                                    style="width:22px;height:22px;border-radius:6px;background:{{ $gradeColor }};display:flex;align-items:center;justify-content:center;font-size:0.7rem;font-weight:800;color:#0d0f1a;flex-shrink:0;">{{ $klien->grade }}</span>
                                <div style="min-width:0;">
                                    <p
                                        style="color:#c8ccdc;font-weight:600;font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                        {{ $klien->nama_perusahaan }}</p>
                                    <p class="valdo-text-muted" style="font-size:0.72rem;">
                                        {{ $klien->jumlah_karyawan }} karyawan &bull; {{ $klien->total_evaluasi }}
                                        evaluasi</p>
                                </div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;">
                                <span
                                    style="font-size:1rem;font-weight:800;color:{{ $gradeColor }};">{{ $klien->avg_nilai_fmt }}</span>
                                <span style="color:#3d4263;font-size:0.72rem;">/100</span>
                            </div>
                        </div>
                        <div class="valdo-progress" style="height:4px;">
                            <div class="valdo-progress-track {{ $klien->avg_nilai >= 70 ? 'green' : ($klien->avg_nilai >= 55 ? 'blue' : 'purple') }}"
                                style="width:{{ $barWidth }}%;"></div>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-top:5px;">
                            <span style="color:#3d4263;font-size:0.68rem;">Min:
                                {{ number_format($klien->nilai_min, 1) }}</span>
                            <span style="color:#3d4263;font-size:0.68rem;">Max:
                                {{ number_format($klien->nilai_max, 1) }}</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align:center;padding:32px 0;">
                        <p class="valdo-text-muted">Belum ada data evaluasi klien</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- STATUS EVALUASI REALTIME --}}
        <div class="valdo-card" style="padding:0;overflow:hidden;">
            <div class="valdo-card-header" style="padding:20px 24px 16px;">
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Monitoring Evaluasi Real-Time</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;">Status pengisian evaluasi 6 bulan terakhir
                    </p>
                </div>
                <div
                    style="width:8px;height:8px;border-radius:50%;background:#34d399;box-shadow:0 0 8px rgba(52,211,153,0.6);animation:valdo-pulse 2s infinite;">
                </div>
            </div>

            <div style="padding:0 24px 24px;display:flex;flex-direction:column;gap:12px;">
                @foreach ($statusEvaluasiRealtime as $bulan)
                    @php
                        $pct = $bulan['completion_pct'];
                        $pctColor = $pct >= 80 ? '#34d399' : ($pct >= 50 ? '#f59e0b' : '#f87171');
                        $isCurrentMonth = $bulan['periode'] === now()->format('Y-m');
                    @endphp
                    <div
                        style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba({{ $isCurrentMonth ? '79,142,247,0.2' : '255,255,255,0.05' }});">
                        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;">
                            <div style="display:flex;align-items:center;gap:8px;">
                                <p style="color:#c8ccdc;font-weight:600;font-size:0.85rem;">{{ $bulan['label'] }}</p>
                                @if ($isCurrentMonth)
                                    <span class="valdo-badge valdo-badge-blue" style="font-size:0.62rem;">Bulan
                                        Ini</span>
                                @endif
                            </div>
                            <div style="display:flex;align-items:center;gap:6px;">
                                <span
                                    style="font-size:0.95rem;font-weight:800;color:{{ $pctColor }};">{{ $pct }}%</span>
                                <span class="valdo-text-muted" style="font-size:0.72rem;">selesai</span>
                            </div>
                        </div>

                        {{-- Progress bar --}}
                        <div class="valdo-progress" style="height:6px;margin-bottom:10px;">
                            <div class="valdo-progress-track {{ $pct >= 80 ? 'green' : ($pct >= 50 ? 'blue' : 'purple') }}"
                                style="width:{{ $pct }}%;"></div>
                        </div>

                        {{-- Status pills --}}
                        <div style="display:flex;gap:6px;flex-wrap:wrap;">
                            @if ($bulan['verified'] > 0)
                                <span
                                    style="font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:5px;background:rgba(52,211,153,0.12);color:#34d399;border:1px solid rgba(52,211,153,0.2);">
                                    ✓ {{ $bulan['verified'] }} Verified
                                </span>
                            @endif
                            @if ($bulan['menunggu_ver'] > 0)
                                <span
                                    style="font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:5px;background:rgba(245,158,11,0.12);color:#f59e0b;border:1px solid rgba(245,158,11,0.2);">
                                    ⏳ {{ $bulan['menunggu_ver'] }} Verifikasi
                                </span>
                            @endif
                            @if ($bulan['menunggu_klien'] > 0)
                                <span
                                    style="font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:5px;background:rgba(107,113,144,0.15);color:#6b7190;border:1px solid rgba(107,113,144,0.2);">
                                    📨 {{ $bulan['menunggu_klien'] }} Klien
                                </span>
                            @endif
                            @if ($bulan['rejected'] > 0)
                                <span
                                    style="font-size:0.68rem;font-weight:700;padding:2px 8px;border-radius:5px;background:rgba(239,68,68,0.12);color:#f87171;border:1px solid rgba(239,68,68,0.2);">
                                    ✕ {{ $bulan['rejected'] }} Ditolak
                                </span>
                            @endif
                            @if ($bulan['total'] === 0)
                                <span style="font-size:0.68rem;color:#3d4263;">Tidak ada evaluasi</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECTION 5: WORKFORCE LEADERBOARD
    ══════════════════════════════════════════════════════════ --}}
    <div class="valdo-card" style="padding:0;overflow:hidden;">
        <div class="valdo-card-header" style="padding:20px 24px 16px;">
            <div class="flex items-center gap-3">
                <div
                    style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,rgba(250,204,21,0.2),rgba(250,204,21,0.08));color:#facc15;display:flex;align-items:center;justify-content:center;box-shadow:var(--neu-shadow-md),0 0 16px rgba(250,204,21,0.12);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon
                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                    </svg>
                </div>
                <div>
                    <p class="valdo-heading-md" style="font-size:0.95rem;">Papan Peringkat Karyawan</p>
                    <p class="valdo-text-muted" style="font-size:0.78rem;">Top 10 performa terbaik perusahaan</p>
                </div>
            </div>
            {{-- Filter Periode --}}
            <div class="valdo-tabs" style="padding:3px;">
                @foreach (['semua' => 'Semua', 'tahun_ini' => 'Tahun Ini', '6_bulan' => '6 Bulan'] as $key => $label)
                    <button wire:click="setLeaderboardPeriode('{{ $key }}')"
                        class="valdo-tab {{ $leaderboardPeriode === $key ? 'active' : '' }}"
                        style="padding:6px 12px;font-size:0.78rem;">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>

        <div wire:loading.class="opacity-50" wire:target="setLeaderboardPeriode">
            @if ($leaderboard->isEmpty())
                <div style="padding:48px 24px;text-align:center;">
                    <p class="valdo-text-muted">Belum ada data evaluasi terverifikasi</p>
                </div>
            @else
                <div
                    style="padding:0 24px 24px;display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:10px;">
                    @foreach ($leaderboard as $idx => $kar)
                        @php
                            $rank = $idx + 1;
                            $rankStyle = match ($rank) {
                                1 => [
                                    'bg' => 'linear-gradient(135deg,rgba(250,204,21,0.15),rgba(250,204,21,0.05))',
                                    'border' => 'rgba(250,204,21,0.25)',
                                    'color' => '#facc15',
                                    'trophy' => '🥇',
                                ],
                                2 => [
                                    'bg' => 'linear-gradient(135deg,rgba(156,163,175,0.15),rgba(156,163,175,0.05))',
                                    'border' => 'rgba(156,163,175,0.2)',
                                    'color' => '#9ca3af',
                                    'trophy' => '🥈',
                                ],
                                3 => [
                                    'bg' => 'linear-gradient(135deg,rgba(180,83,9,0.15),rgba(180,83,9,0.05))',
                                    'border' => 'rgba(180,83,9,0.2)',
                                    'color' => '#b45309',
                                    'trophy' => '🥉',
                                ],
                                default => [
                                    'bg' => 'var(--color-base-400)',
                                    'border' => 'rgba(255,255,255,0.05)',
                                    'color' => '#3d4263',
                                    'trophy' => '#' . $rank,
                                ],
                            };
                            $gradeColor = match ($kar->grade) {
                                'A' => '#34d399',
                                'B' => 'var(--color-accent-cyan)',
                                'C' => '#f59e0b',
                                'D' => '#f87171',
                            };
                        @endphp
                        <div style="background:{{ $rankStyle['bg'] }};border-radius:12px;padding:14px 16px;border:1px solid {{ $rankStyle['border'] }};display:flex;align-items:center;gap:12px;transition:all 0.2s;"
                            x-on:mouseenter="$el.style.transform='translateY(-2px)'"
                            x-on:mouseleave="$el.style.transform='translateY(0)'">

                            {{-- Rank --}}
                            <div
                                style="width:32px;height:32px;border-radius:10px;background:var(--color-base-200);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:{{ $rank <= 3 ? '1rem' : '0.75rem' }};font-weight:700;color:{{ $rankStyle['color'] }};">
                                {{ $rankStyle['trophy'] }}
                            </div>

                            {{-- Avatar --}}
                            <div class="valdo-table-avatar"
                                style="flex-shrink:0;width:36px;height:36px;border-radius:10px;font-size:0.8rem;">
                                {{ strtoupper(substr($kar->nama_karyawan, 0, 2)) }}
                            </div>

                            {{-- Info --}}
                            <div style="flex:1;min-width:0;">
                                <p
                                    style="color:#c8ccdc;font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                    {{ $kar->nama_karyawan }}</p>
                                <p style="color:#6b7190;font-size:0.75rem;">{{ $kar->posisi }}</p>
                            </div>

                            {{-- Score --}}
                            <div style="text-align:right;flex-shrink:0;">
                                <div style="display:flex;align-items:center;gap:4px;justify-content:flex-end;">
                                    <span
                                        style="width:14px;height:14px;border-radius:4px;background:{{ $gradeColor }};display:flex;align-items:center;justify-content:center;font-size:0.6rem;font-weight:800;color:#0d0f1a;">{{ $kar->grade }}</span>
                                    <span
                                        style="font-size:1rem;font-weight:800;color:{{ $gradeColor }};">{{ $kar->avg_nilai_fmt }}</span>
                                </div>
                                <p style="color:#3d4263;font-size:0.68rem;margin-top:1px;">{{ $kar->total_evaluasi }}
                                    evaluasi</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         SCRIPTS: Chart.js via CDN (lazy, tidak blokir render)
    ══════════════════════════════════════════════════════════ --}}
    @push('scripts')
        <script>
            // Lazy-load Chart.js hanya jika belum ada
            function loadChartJs(callback) {
                if (window.Chart) {
                    callback();
                    return;
                }
                const s = document.createElement('script');
                s.src = 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js';
                s.onload = callback;
                document.head.appendChild(s);
            }

            function initCharts() {
                // ── YoY Line Chart ──────────────────────────────────
                const yoyEl = document.getElementById('yoyChart');
                if (yoyEl && !yoyEl._chartInited) {
                    yoyEl._chartInited = true;
                    const ctx = yoyEl.getContext('2d');

                    // Gradient fill tahun ini
                    const gradIni = ctx.createLinearGradient(0, 0, 0, 200);
                    gradIni.addColorStop(0, 'rgba(79,142,247,0.3)');
                    gradIni.addColorStop(1, 'rgba(79,142,247,0)');

                    const gradLalu = ctx.createLinearGradient(0, 0, 0, 200);
                    gradLalu.addColorStop(0, 'rgba(139,92,246,0.15)');
                    gradLalu.addColorStop(1, 'rgba(139,92,246,0)');

                    const labels = JSON.parse(yoyEl.dataset.labels);
                    const iniData = JSON.parse(yoyEl.dataset.ini);
                    const laluData = JSON.parse(yoyEl.dataset.lalu);
                    const tahun = yoyEl.dataset.tahun;
                    const tahunLalu = yoyEl.dataset.tahunlalu;

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels,
                            datasets: [{
                                    label: tahun,
                                    data: iniData,
                                    borderColor: '#4f8ef7',
                                    backgroundColor: gradIni,
                                    borderWidth: 2.5,
                                    pointBackgroundColor: '#4f8ef7',
                                    pointBorderColor: '#1c1f30',
                                    pointBorderWidth: 2,
                                    pointRadius: 5,
                                    pointHoverRadius: 7,
                                    fill: true,
                                    tension: 0.45,
                                    spanGaps: true,
                                },
                                {
                                    label: tahunLalu,
                                    data: laluData,
                                    borderColor: '#8b5cf6',
                                    backgroundColor: gradLalu,
                                    borderWidth: 2,
                                    borderDash: [5, 5],
                                    pointBackgroundColor: '#8b5cf6',
                                    pointBorderColor: '#1c1f30',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    fill: true,
                                    tension: 0.45,
                                    spanGaps: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: true,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#1c1f30',
                                    borderColor: 'rgba(255,255,255,0.07)',
                                    borderWidth: 1,
                                    titleColor: '#e2e5f0',
                                    bodyColor: '#8892b0',
                                    padding: 12,
                                    cornerRadius: 10,
                                    callbacks: {
                                        label: ctx =>
                                            ` ${ctx.dataset.label}: ${ctx.parsed.y !== null ? ctx.parsed.y : '—'}`,
                                    }
                                }
                            },
                            scales: {
                                x: {
                                    grid: {
                                        color: 'rgba(255,255,255,0.04)',
                                        drawTicks: false
                                    },
                                    ticks: {
                                        color: '#3d4263',
                                        font: {
                                            size: 11
                                        }
                                    },
                                    border: {
                                        display: false
                                    },
                                },
                                y: {
                                    min: 0,
                                    max: 100,
                                    grid: {
                                        color: 'rgba(255,255,255,0.04)',
                                        drawTicks: false
                                    },
                                    ticks: {
                                        color: '#3d4263',
                                        font: {
                                            size: 11
                                        },
                                        stepSize: 20
                                    },
                                    border: {
                                        display: false
                                    },
                                }
                            }
                        }
                    });
                }

                // ── Donut Grade Chart ───────────────────────────────
                const gradeEl = document.getElementById('gradeChart');
                if (gradeEl && !gradeEl._chartInited) {
                    gradeEl._chartInited = true;
                    const grades = JSON.parse(gradeEl.dataset.grades);
                    new Chart(gradeEl.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: ['Grade A', 'Grade B', 'Grade C', 'Grade D'],
                            datasets: [{
                                data: grades,
                                backgroundColor: ['#34d399', '#22d3ee', '#f59e0b', '#f87171'],
                                borderColor: '#1c1f30',
                                borderWidth: 3,
                                hoverOffset: 8,
                            }]
                        },
                        options: {
                            responsive: true,
                            cutout: '72%',
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: '#1c1f30',
                                    borderColor: 'rgba(255,255,255,0.07)',
                                    borderWidth: 1,
                                    titleColor: '#e2e5f0',
                                    bodyColor: '#8892b0',
                                    padding: 10,
                                    cornerRadius: 10,
                                }
                            }
                        }
                    });
                }
            }

            // Init saat DOM siap
            document.addEventListener('DOMContentLoaded', () => {
                loadChartJs(initCharts);
            });

            // Re-init setelah Livewire update (jika navigate antar halaman)
            document.addEventListener('livewire:navigated', () => {
                loadChartJs(initCharts);
            });
        </script>
    @endpush

</div>

@push('scripts')
    {{-- Alpine data untuk dashboard --}}
    <script>
        function valdoDashboard() {
            return {
                init() {
                    // Pastikan chart terinit setelah alpine selesai
                    this.$nextTick(() => {
                        if (window.Chart) initCharts();
                        else setTimeout(() => {
                            if (window.Chart) initCharts();
                        }, 800);
                    });
                }
            }
        }
    </script>
@endpush
