<div>
    {{-- ============================================================
         HEADER
    ============================================================ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="valdo-heading-lg">Manajemen Kontrak Karyawan</h1>
            <p class="valdo-text-muted mt-1">Pantau status kontrak seluruh karyawan dan kelola perpanjangannya secara
                terpusat.</p>
        </div>
    </div>

    {{-- ============================================================
         SUMMARY CARDS
    ============================================================ --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        {{-- Total --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $summary['total'] }}</div>
            <div class="valdo-stat-label">Total Karyawan</div>
        </div>

        {{-- Aktif --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon cyan">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $summary['aktif'] }}</div>
            <div class="valdo-stat-label">Kontrak Aktif</div>
        </div>

        {{-- Hampir Habis --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon pink">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $summary['hampir_habis'] }}</div>
            <div class="valdo-stat-label">Hampir Habis</div>
        </div>

        {{-- Sudah Habis --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon purple">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $summary['sudah_habis'] }}</div>
            <div class="valdo-stat-label">Sudah Habis</div>
        </div>

        {{-- Belum Ada Kontrak --}}
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="8.5" cy="7" r="4" />
                    <line x1="20" y1="8" x2="20" y2="14" />
                    <line x1="23" y1="11" x2="17" y2="11" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $summary['belum_ada_kontrak'] }}</div>
            <div class="valdo-stat-label">Belum Ada Kontrak</div>
        </div>
    </div>

    {{-- ============================================================
         FILTER BAR
    ============================================================ --}}
    <div class="valdo-card mb-6">
        <div class="flex flex-col md:flex-row gap-4 md:items-end">
            <div class="flex-1">
                <label class="valdo-label">Cari Karyawan</label>
                <div class="valdo-input-wrapper mt-1.5">
                    <span class="valdo-input-prefix">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <line x1="21" y1="21" x2="16.65" y2="16.65" />
                        </svg>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        placeholder="Cari nama, NIK, atau posisi..." class="valdo-input">
                </div>
            </div>

            <div class="w-full md:w-64">
                <label class="valdo-label">Filter Status Kontrak</label>
                <div class="valdo-select-wrapper mt-1.5">
                    <select wire:model.live="filterStatus" class="valdo-select">
                        <option value="">Semua Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="hampir_habis">Hampir Habis</option>
                        <option value="sudah_habis">Sudah Habis</option>
                        <option value="belum_ada_kontrak">Belum Ada Kontrak</option>
                    </select>
                </div>
            </div>

            @if ($search || $filterStatus)
                <button type="button" wire:click="$set('search', ''); $set('filterStatus', '')"
                    class="valdo-btn valdo-btn-ghost">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Reset
                </button>
            @endif
        </div>
    </div>

    {{-- ============================================================
         TABLE
    ============================================================ --}}
    <div class="valdo-table-wrapper" wire:loading.class="opacity-60" wire:target="search,filterStatus">
        <table class="valdo-table">
            <thead>
                <tr>
                    <th>Karyawan</th>
                    <th>NIK</th>
                    <th>Posisi</th>
                    <th>Status Kontrak</th>
                    <th>Berakhir</th>
                    <th>Sisa Waktu</th>
                    <th class="text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($karyawanList as $karyawan)
                    @php
                        $kontrak = $karyawan->kontrakAktif;
                        $sisa = $kontrak?->sisaHari();

                        [$statusClass, $statusLabel] = match (true) {
                            !$kontrak => ['valdo-badge-muted', 'Belum Ada Kontrak'],
                            $kontrak->sudahHabis() => ['valdo-badge-red', 'Sudah Habis'],
                            $kontrak->hampirHabis() => ['valdo-badge-pink', 'Hampir Habis'],
                            default => ['valdo-badge-green', 'Aktif'],
                        };

                        $initial = mb_strtoupper(mb_substr($karyawan->nama_karyawan, 0, 1));
                    @endphp
                    <tr wire:key="karyawan-{{ $karyawan->id_karyawan }}">
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="valdo-table-avatar">{{ $initial }}</div>
                                <div>
                                    <div style="color:#e2e5f0; font-weight:600; font-size:0.875rem;">
                                        {{ $karyawan->nama_karyawan }}</div>
                                    <div class="valdo-text-muted" style="font-size:0.75rem;">
                                        {{ $karyawan->jenis_kelamin }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="valdo-text-mono">{{ $karyawan->nik }}</td>
                        <td>{{ $karyawan->posisi }}</td>
                        <td>
                            <span class="valdo-badge {{ $statusClass }}">{{ $statusLabel }}</span>
                        </td>
                        <td>{{ $kontrak?->tanggal_selesai?->format('d M Y') ?? '—' }}</td>
                        <td>
                            @if ($kontrak)
                                <span
                                    style="font-size:0.8125rem; color: {{ $sisa < 0 ? '#f87171' : ($sisa <= 30 ? '#e879f9' : '#a8adc4') }};">
                                    {{ $sisa >= 0 ? $sisa . ' hari' : 'Lewat ' . abs($sisa) . ' hari' }}
                                </span>
                            @else
                                <span class="valdo-text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-right">
                            <a href="{{ route('admin.kontrak.show', ['id_karyawan' => $karyawan->id_karyawan]) }}"
                                wire:navigate class="valdo-btn valdo-btn-secondary valdo-btn-sm">
                                Detail
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center valdo-text-muted" style="padding: 48px 20px;">
                            Tidak ada data karyawan yang cocok dengan pencarian/filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ============================================================
         PAGINATION
    ============================================================ --}}
    <div class="mt-6">

    </div>
</div>
