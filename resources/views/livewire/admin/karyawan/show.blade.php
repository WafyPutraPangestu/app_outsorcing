<div>

    {{-- ── BREADCRUMB ── --}}
    <div class="flex items-center gap-2 mb-6" style="color:#3d4263; font-size:0.8rem;">
        <a href="{{ route('admin.karyawan.index') }}" wire:navigate class="hover:text-accent-blue transition-colors"
            style="color:#6b7190;">Karyawan</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6" />
        </svg>
        <span style="color:#4f8ef7;">{{ $karyawan->nama_karyawan }}</span>
    </div>

    {{-- ── HERO PROFILE CARD ── --}}
    <div class="valdo-card mb-6" style="padding:0; overflow:hidden;">
        {{-- Cover gradient bar --}}
        <div
            style="height:80px; background:linear-gradient(135deg, rgba(79,142,247,0.25) 0%, rgba(139,92,246,0.25) 50%, rgba(34,211,238,0.15) 100%); position:relative;">
            <div
                style="position:absolute;inset:0;background:url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 200 80%22><circle cx=%22150%22 cy=%2220%22 r=%2260%22 fill=%22rgba(79,142,247,0.1)%22/><circle cx=%2230%22 cy=%2270%22 r=%2240%22 fill=%22rgba(139,92,246,0.08)%22/></svg>');background-size:cover;">
            </div>
        </div>

        <div style="padding:0 28px 28px;">
            {{-- Avatar --}}
            <div style="display:flex; align-items:flex-end; justify-content:space-between; margin-top:-36px;">
                <div
                    style="width:72px;height:72px;border-radius:20px;background:linear-gradient(135deg,var(--color-accent-blue),var(--color-accent-purple));display:flex;align-items:center;justify-content:center;font-size:1.5rem;font-weight:800;color:#fff;box-shadow:0 0 24px var(--glow-blue), 0 8px 20px rgba(0,0,0,0.5);border:3px solid var(--color-base-300);">
                    {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}
                </div>
                <div class="flex gap-2" style="padding-bottom:4px;">
                    <a href="{{ route('admin.karyawan.edit', $karyawan->id_karyawan) }}" wire:navigate
                        class="valdo-btn valdo-btn-secondary valdo-btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                        Edit
                    </a>
                    <a href="{{ route('admin.karyawan.index') }}" wire:navigate
                        class="valdo-btn valdo-btn-ghost valdo-btn-sm">Kembali</a>
                </div>
            </div>

            {{-- Name & Meta --}}
            <div style="margin-top:16px;">
                <div class="flex items-center gap-3 flex-wrap">
                    <h2 class="valdo-heading-lg" style="font-size:1.5rem;">{{ $karyawan->nama_karyawan }}</h2>
                    @if ($karyawan->status_karyawan === 'aktif')
                        <span class="valdo-badge valdo-badge-green">
                            <span
                                style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;animation:valdo-pulse 2s infinite;"></span>
                            Aktif
                        </span>
                    @else
                        <span class="valdo-badge valdo-badge-muted">Nonaktif</span>
                    @endif
                </div>
                <div class="flex items-center gap-4 mt-2 flex-wrap">
                    <span class="valdo-text-mono">{{ $karyawan->nik }}</span>
                    <span class="valdo-divider-vertical" style="height:14px;"></span>
                    <span style="color:#8892b0; font-size:0.875rem;">{{ $karyawan->posisi }}</span>
                    <span class="valdo-divider-vertical" style="height:14px;"></span>
                    <span style="color:#6b7190; font-size:0.8125rem;">{{ $karyawan->jenis_kelamin }}</span>
                </div>
            </div>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-6">
                @php
                    $totalPenempatan = $karyawan->penempatan->count();
                    $penempatanAktif = $karyawan->penempatan->where('status_aktif', true)->first();
                    $totalEvaluasi = $karyawan->penempatan->flatMap->evaluasi->count();
                    $avgNilai = $karyawan->penempatan->flatMap->evaluasi
                        ->where('status_evaluasi', 'verified')
                        ->avg('total_nilai_akhir');
                @endphp
                <div
                    style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);box-shadow:var(--neu-shadow-sm);">
                    <p class="valdo-text-label" style="margin-bottom:6px;">Total Penempatan</p>
                    <p style="font-size:1.5rem;font-weight:800;color:#e2e5f0;">{{ $totalPenempatan }}</p>
                </div>
                <div
                    style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);box-shadow:var(--neu-shadow-sm);">
                    <p class="valdo-text-label" style="margin-bottom:6px;">Total Evaluasi</p>
                    <p style="font-size:1.5rem;font-weight:800;color:#e2e5f0;">{{ $totalEvaluasi }}</p>
                </div>
                <div
                    style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);box-shadow:var(--neu-shadow-sm);">
                    <p class="valdo-text-label" style="margin-bottom:6px;">Rata-rata Nilai</p>
                    <p
                        style="font-size:1.5rem;font-weight:800;color:{{ $avgNilai >= 70 ? '#34d399' : ($avgNilai >= 50 ? '#f59e0b' : '#f87171') }};">
                        {{ $avgNilai ? number_format($avgNilai, 1) : '—' }}
                    </p>
                </div>
                <div
                    style="background:var(--color-base-400);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);box-shadow:var(--neu-shadow-sm);">
                    <p class="valdo-text-label" style="margin-bottom:6px;">Klien Saat Ini</p>
                    <p
                        style="font-size:0.875rem;font-weight:700;color:#c8ccdc;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ $penempatanAktif?->klien?->nama_perusahaan ?? '—' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── KOLOM KIRI: BIODATA ── --}}
        <div class="flex flex-col gap-6">

            {{-- Biodata Card --}}
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <span class="valdo-heading-md" style="font-size:0.9rem;">Biodata Lengkap</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                        fill="none" stroke="#3d4263" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>

                @php
                    $fields = [
                        ['label' => 'NIK', 'value' => $karyawan->nik, 'mono' => true],
                        ['label' => 'Nama Lengkap', 'value' => $karyawan->nama_karyawan],
                        ['label' => 'Jenis Kelamin', 'value' => $karyawan->jenis_kelamin],
                        ['label' => 'Posisi', 'value' => $karyawan->posisi],
                        ['label' => 'No. HP', 'value' => $karyawan->no_hp ?: '—'],
                        ['label' => 'Alamat', 'value' => $karyawan->alamat ?: '—'],
                    ];
                @endphp

                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach ($fields as $field)
                        <div>
                            <p class="valdo-text-label" style="margin-bottom:3px;">{{ $field['label'] }}</p>
                            @if (!empty($field['mono']))
                                <p class="valdo-text-mono">{{ $field['value'] }}</p>
                            @else
                                <p style="color:#c8ccdc; font-size:0.875rem; line-height:1.5;">
                                    {{ $field['value'] }}</p>
                            @endif
                        </div>
                        @if (!$loop->last)
                            <div class="valdo-divider" style="margin:0;"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Timestamps --}}
            <div class="valdo-card">
                <p class="valdo-text-label mb-4">Catatan Sistem</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="#3d4263" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                        <div>
                            <p style="color:#3d4263;font-size:0.7rem;">Terdaftar sejak</p>
                            <p style="color:#8892b0;font-size:0.8rem;">
                                {{ $karyawan->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24"
                            fill="none" stroke="#3d4263" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10" />
                        </svg>
                        <div>
                            <p style="color:#3d4263;font-size:0.7rem;">Terakhir diperbarui</p>
                            <p style="color:#8892b0;font-size:0.8rem;">
                                {{ $karyawan->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── KOLOM KANAN: RIWAYAT PENEMPATAN ── --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- Riwayat Penempatan --}}
            <div class="valdo-card" style="padding:0;">
                <div class="valdo-card-header" style="padding:20px 24px 16px;">
                    <div class="flex items-center gap-3">
                        <div class="valdo-stat-card-icon purple"
                            style="width:34px;height:34px;border-radius:10px;margin-bottom:0;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" ry="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <span class="valdo-heading-md" style="font-size:0.95rem;">Riwayat Penempatan</span>
                    </div>
                    <span class="valdo-badge valdo-badge-purple">{{ $karyawan->penempatan->count() }} Total</span>
                </div>

                @if ($karyawan->penempatan->isEmpty())
                    <div style="padding:48px 24px; text-align:center;">
                        <div
                            style="width:48px;height:48px;border-radius:14px;background:var(--color-base-400);display:flex;align-items:center;justify-content:center;margin:0 auto 12px;box-shadow:var(--neu-shadow-md);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                viewBox="0 0 24 24" fill="none" stroke="#3d4263" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="7" width="20" height="14" rx="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <p class="valdo-text-muted">Belum ada data penempatan</p>
                    </div>
                @else
                    {{-- Timeline Penempatan --}}
                    <div style="padding:8px 24px 24px;">
                        @foreach ($karyawan->penempatan->sortByDesc('tanggal_mulai') as $penempatan)
                            @php
                                $isAktif = $penempatan->status_aktif;
                                $evalVerified = $penempatan->evaluasi->where('status_evaluasi', 'verified');
                                $avgEval = $evalVerified->avg('total_nilai_akhir');
                                $rekLabel = match ($penempatan->rekomendasi_sistem) {
                                    'lanjut_kontrak' => ['text' => 'Lanjut Kontrak', 'class' => 'valdo-badge-cyan'],
                                    'putus_kontrak' => ['text' => 'Putus Kontrak', 'class' => 'valdo-badge-red'],
                                    default => ['text' => 'Belum Dievaluasi', 'class' => 'valdo-badge-muted'],
                                };
                            @endphp
                            <div
                                style="position:relative; padding-left:28px; margin-bottom:{{ !$loop->last ? '24px' : '0' }};">
                                {{-- Timeline dot & line --}}
                                <div
                                    style="position:absolute;left:0;top:8px;width:12px;height:12px;border-radius:50%;background:{{ $isAktif ? 'var(--color-accent-blue)' : 'var(--color-base-500)' }};box-shadow:{{ $isAktif ? '0 0 8px var(--glow-blue)' : 'none' }};z-index:1;">
                                </div>
                                @if (!$loop->last)
                                    <div
                                        style="position:absolute;left:5px;top:20px;width:2px;height:calc(100% + 8px);background:linear-gradient(180deg,rgba(79,142,247,0.2),transparent);">
                                    </div>
                                @endif

                                {{-- Penempatan Card --}}
                                <div
                                    style="background:var(--color-base-400);border-radius:14px;padding:16px;border:1px solid rgba(255,255,255,{{ $isAktif ? '0.08' : '0.04' }});box-shadow:{{ $isAktif ? 'var(--neu-shadow-md), 0 0 20px rgba(79,142,247,0.08)' : 'var(--neu-shadow-sm)' }};">

                                    <div class="flex items-start justify-between gap-3 flex-wrap">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1 flex-wrap">
                                                <p style="font-weight:600;color:#c8ccdc;font-size:0.9rem;">
                                                    {{ $penempatan->klien->nama_perusahaan }}
                                                </p>
                                                @if ($isAktif)
                                                    <span class="valdo-badge valdo-badge-blue"
                                                        style="font-size:0.65rem;">Aktif</span>
                                                @endif
                                            </div>
                                            <p class="valdo-text-muted" style="font-size:0.78rem;">
                                                {{ $penempatan->tanggal_mulai->format('d M Y') }}
                                                —
                                                {{ $penempatan->tanggal_selesai ? $penempatan->tanggal_selesai->format('d M Y') : 'Sekarang' }}
                                            </p>
                                        </div>
                                        <span class="valdo-badge {{ $rekLabel['class'] }}" style="flex-shrink:0;">
                                            {{ $rekLabel['text'] }}
                                        </span>
                                    </div>

                                    {{-- Evaluasi mini stats --}}
                                    @if ($penempatan->evaluasi->isNotEmpty())
                                        <div class="valdo-divider" style="margin:12px 0;"></div>
                                        <div class="flex items-center gap-4 flex-wrap">
                                            <div>
                                                <p class="valdo-text-label" style="margin-bottom:2px;">Evaluasi
                                                </p>
                                                <p style="color:#c8ccdc;font-size:0.875rem;font-weight:600;">
                                                    {{ $evalVerified->count() }}/{{ $penempatan->evaluasi->count() }}
                                                    Verified
                                                </p>
                                            </div>
                                            @if ($avgEval)
                                                <div>
                                                    <p class="valdo-text-label" style="margin-bottom:2px;">
                                                        Rata-rata Nilai</p>
                                                    <p
                                                        style="font-size:0.875rem;font-weight:700;color:{{ $avgEval >= 70 ? '#34d399' : ($avgEval >= 50 ? '#f59e0b' : '#f87171') }};">
                                                        {{ number_format($avgEval, 1) }} / 100
                                                    </p>
                                                </div>
                                                <div style="flex:1;min-width:100px;">
                                                    <div class="valdo-progress">
                                                        <div class="valdo-progress-track {{ $avgEval >= 70 ? 'green' : ($avgEval >= 50 ? 'blue' : 'purple') }}"
                                                            style="width:{{ min($avgEval, 100) }}%;"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Evaluasi list ringkas --}}
                                        <div style="margin-top:10px;display:flex;flex-wrap:wrap;gap:6px;">
                                            @foreach ($penempatan->evaluasi->sortByDesc('periode')->take(6) as $ev)
                                                @php
                                                    $evColor = match ($ev->status_evaluasi) {
                                                        'verified' => '#34d399',
                                                        'menunggu_verifikasi' => '#f59e0b',
                                                        'rejected' => '#f87171',
                                                        default => '#3d4263',
                                                    };
                                                @endphp
                                                <div style="background:var(--color-base-300);border-radius:8px;padding:5px 10px;border:1px solid rgba(255,255,255,0.04);"
                                                    title="Status: {{ $ev->status_evaluasi }}">
                                                    <p
                                                        style="color:#6b7190;font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">
                                                        {{ $ev->periode }}</p>
                                                    <p
                                                        style="color:{{ $evColor }};font-size:0.8rem;font-weight:700;">
                                                        {{ $ev->total_nilai_akhir ? number_format($ev->total_nilai_akhir, 0) : '—' }}
                                                    </p>
                                                </div>
                                            @endforeach
                                            @if ($penempatan->evaluasi->count() > 6)
                                                <div
                                                    style="background:var(--color-base-300);border-radius:8px;padding:5px 10px;border:1px solid rgba(255,255,255,0.04);display:flex;align-items:center;">
                                                    <span
                                                        style="color:#3d4263;font-size:0.78rem;">+{{ $penempatan->evaluasi->count() - 6 }}
                                                        lagi</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="valdo-divider" style="margin:12px 0;"></div>
                                        <p class="valdo-text-muted" style="font-size:0.78rem;">Belum ada data
                                            evaluasi</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>

</div>
