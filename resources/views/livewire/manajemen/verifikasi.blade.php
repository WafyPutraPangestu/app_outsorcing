<div x-data="{ toastShow: false, toastMsg: '', toastType: 'success' }" x-init="@if (session('toast_success')) toastMsg = '{{ session('toast_success') }}'; toastType = 'success'; toastShow = true;
            setTimeout(() => toastShow = false, 4500); @endif
@if (session('toast_error')) toastMsg = '{{ session('toast_error') }}'; toastType = 'error'; toastShow = true;
            setTimeout(() => toastShow = false, 4500); @endif">

    {{-- ══ LIVEWIRE LOADING BAR ══ --}}
    <div wire:loading.flex class="valdo-wire-loading-bar" style="display:none;"></div>

    {{-- ══ TOAST ══ --}}
    <div x-show="toastShow" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-1 translate-y-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-1"
        x-transition:leave-end="opacity-0" :class="'valdo-toast ' + toastType"
        style="position:fixed;bottom:24px;right:24px;z-index:var(--z-toast);min-width:300px;pointer-events:auto;"
        x-cloak>
        <div class="valdo-toast-icon">
            <template x-if="toastType === 'success'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </template>
            <template x-if="toastType === 'error'">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </template>
        </div>
        <div class="valdo-toast-content">
            <p class="valdo-toast-title" x-text="toastMsg"></p>
        </div>
        <button @click="toastShow=false" class="valdo-modal-close" style="flex-shrink:0;margin-left:auto;">
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    {{-- ══ HEADER ══ --}}
    <div class="flex items-start justify-between mb-7 flex-wrap gap-4">
        <div>
            <p class="valdo-text-label mb-1">Quality Control</p>
            <h1 class="valdo-heading-lg">Verifikasi Penilaian</h1>
            <p class="valdo-text-muted mt-1">Tinjau dan sahkan nilai yang dikirimkan oleh klien</p>
        </div>
        {{-- Bulk Approve button muncul saat ada yang dicentang --}}
        @if (count($selected) > 0)
            <div x-data style="display:flex;align-items:center;gap:10px;" x-show="true"
                x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-1 scale-100">
                <span class="valdo-badge valdo-badge-blue">{{ count($selected) }} dipilih</span>
                <button wire:click="$set('showBulkKonfirmasi', true)" class="valdo-btn valdo-btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                    Verifikasi {{ count($selected) }} Terpilih
                </button>
                <button wire:click="$set('selected', []); $set('selectAll', false)"
                    class="valdo-btn valdo-btn-ghost">Batal</button>
            </div>
        @endif
    </div>

    {{-- ══ STATS MINI ══ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-7">
        <div class="valdo-stat-card" style="padding:16px 20px;">
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                <span class="valdo-text-label">Menunggu Verifikasi</span>
                <div
                    style="width:8px;height:8px;border-radius:50%;background:#f59e0b;box-shadow:0 0 8px rgba(245,158,11,0.6);animation:valdo-pulse 2s infinite;">
                </div>
            </div>
            <div style="font-size:2rem;font-weight:800;color:#f59e0b;line-height:1;">{{ $statsAntrean['total'] }}</div>
            <div class="valdo-text-muted" style="font-size:0.75rem;margin-top:4px;">total antrean aktif</div>
        </div>
        <div class="valdo-stat-card" style="padding:16px 20px;">
            <div style="margin-bottom:8px;"><span class="valdo-text-label">Periode Ini</span></div>
            <div style="font-size:2rem;font-weight:800;color:var(--color-accent-blue);line-height:1;">
                {{ $statsAntrean['bulan_ini'] }}</div>
            <div class="valdo-text-muted" style="font-size:0.75rem;margin-top:4px;">
                {{ now()->translatedFormat('F Y') }}</div>
        </div>
        <div class="valdo-stat-card col-span-2 sm:col-span-1" style="padding:16px 20px;">
            <div style="margin-bottom:8px;"><span class="valdo-text-label">Menunggu Terlama</span></div>
            <div style="font-size:1rem;font-weight:700;color:#c8ccdc;line-height:1.3;">
                {{ $statsAntrean['tertua'] ?? '—' }}
            </div>
            <div class="valdo-text-muted" style="font-size:0.75rem;margin-top:4px;">dari tanggal submit</div>
        </div>
    </div>

    {{-- ══ TABS ══ --}}
    <div
        style="display:flex;gap:4px;background:var(--color-base-200);border-radius:12px;padding:4px;box-shadow:var(--neu-inset);border:1px solid rgba(255,255,255,0.04);margin-bottom:24px;width:fit-content;">
        <button wire:click="$set('tab', 'antrean')" class="valdo-tab {{ $tab === 'antrean' ? 'active' : '' }}"
            style="display:flex;align-items:center;gap:8px;padding:8px 20px;font-size:0.875rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" />
                <polyline points="12 6 12 12 16 14" />
            </svg>
            Antrean Pending
            @if ($statsAntrean['total'] > 0)
                <span
                    style="min-width:20px;height:20px;border-radius:6px;background:rgba(245,158,11,0.2);color:#f59e0b;font-size:0.7rem;font-weight:700;display:inline-flex;align-items:center;justify-content:center;padding:0 5px;">
                    {{ $statsAntrean['total'] }}
                </span>
            @endif
        </button>
        <button wire:click="$set('tab', 'riwayat')" class="valdo-tab {{ $tab === 'riwayat' ? 'active' : '' }}"
            style="display:flex;align-items:center;gap:8px;padding:8px 20px;font-size:0.875rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Riwayat Verifikasi
        </button>
    </div>

    {{-- ════════════════════════════════════════════
         TAB: ANTREAN PENDING
    ════════════════════════════════════════════ --}}
    @if ($tab === 'antrean')
        <div class="valdo-table-wrapper" wire:loading.class="opacity-60"
            wire:target="search,filterPeriode,filterKlien,perPage">

            {{-- Toolbar --}}
            <div
                style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                {{-- Search --}}
                <div class="valdo-search" style="max-width:260px;flex:1;min-width:180px;">
                    <svg class="valdo-search-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text" class="valdo-search-input"
                        placeholder="Cari nama / NIK karyawan...">
                </div>

                {{-- Filter Periode --}}
                <div class="valdo-select-wrapper" style="flex-shrink:0;">
                    <select wire:model.live="filterPeriode" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;">
                        <option value="">Semua Periode</option>
                        @foreach ($opsiPeriode as $p)
                            <option value="{{ $p }}">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Klien --}}
                <div class="valdo-select-wrapper" style="flex-shrink:0;">
                    <select wire:model.live="filterKlien" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;max-width:200px;">
                        <option value="">Semua Klien</option>
                        @foreach ($opsiKlien as $k)
                            <option value="{{ $k->id_klien }}">{{ Str::limit($k->nama_perusahaan, 30) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Perpage --}}
                <div class="valdo-select-wrapper" style="margin-left:auto;flex-shrink:0;">
                    <select wire:model.live="perPage" class="valdo-select"
                        style="width:auto;padding-right:30px;font-size:0.8rem;">
                        <option value="15">15</option>
                        <option value="30">30</option>
                        <option value="50">50</option>
                    </select>
                </div>

                {{-- Reset filter --}}
                @if ($search || $filterPeriode || $filterKlien)
                    <button wire:click="$set('search',''); $set('filterPeriode',''); $set('filterKlien','')"
                        class="valdo-btn valdo-btn-ghost valdo-btn-sm" style="flex-shrink:0;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                        Reset
                    </button>
                @endif
            </div>

            {{-- Loading shimmer --}}
            <div wire:loading.block wire:target="search,filterPeriode,filterKlien,perPage" style="padding:40px 24px;">
                @for ($i = 0; $i < 5; $i++)
                    <div class="valdo-skeleton" style="height:52px;border-radius:8px;margin-bottom:8px;"></div>
                @endfor
            </div>

            {{-- Table --}}
            <div wire:loading.remove wire:target="search,filterPeriode,filterKlien,perPage">
                <table class="valdo-table" style="min-width:800px;">
                    <thead>
                        <tr>
                            <th style="width:40px;padding-left:20px;">
                                <label class="valdo-checkbox-wrapper" style="gap:0;">
                                    <div class="valdo-checkbox {{ $selectAll ? 'checked' : '' }}"
                                        wire:click="$set('selectAll', {{ $selectAll ? 'false' : 'true' }})">
                                        @if ($selectAll)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        @endif
                                    </div>
                                </label>
                            </th>
                            <th>Karyawan</th>
                            <th>Klien</th>
                            <th>Periode</th>
                            <th>Tgl Submit</th>
                            <th>Nilai Sementara</th>
                            <th style="text-align:center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($antrean as $ev)
                            @php
                                // Hitung nilai sementara weighted
                                $totalBobot = 0;
                                $totalNilai = 0;
                                foreach ($ev->detail as $d) {
                                    $b = $d->kriteria->bobot_nilai ?? 1;
                                    $totalBobot += $b;
                                    $totalNilai += $d->skor_nilai * $b;
                                }
                                $nilaiTemp = $totalBobot > 0 ? round($totalNilai / $totalBobot, 1) : 0;
                                $nilaiColor = $nilaiTemp >= 70 ? '#34d399' : ($nilaiTemp >= 55 ? '#f59e0b' : '#f87171');
                                $isSelected = in_array((string) $ev->id_evaluasi, array_map('strval', $selected));
                            @endphp
                            <tr class="{{ $isSelected ? 'active' : '' }}" style="cursor:default;">
                                {{-- Checkbox --}}
                                <td style="padding-left:20px;">
                                    <div class="valdo-checkbox {{ $isSelected ? 'checked' : '' }}"
                                        wire:click="
                                            @if ($isSelected) $set('selected', {{ json_encode(array_values(array_filter($selected, fn($x) => $x != (string) $ev->id_evaluasi))) }})
                                            @else
                                                $set('selected', {{ json_encode(array_merge($selected, [(string) $ev->id_evaluasi])) }}) @endif
                                         ">
                                        @if ($isSelected)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="3.5"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                {{-- Karyawan --}}
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="valdo-table-avatar" style="flex-shrink:0;">
                                            {{ strtoupper(substr($ev->penempatan->karyawan->nama_karyawan, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p style="color:#c8ccdc;font-weight:500;font-size:0.875rem;">
                                                {{ $ev->penempatan->karyawan->nama_karyawan }}</p>
                                            <p class="valdo-text-mono" style="font-size:0.72rem;">
                                                {{ $ev->penempatan->karyawan->nik }}</p>
                                        </div>
                                    </div>
                                </td>
                                {{-- Klien --}}
                                <td>
                                    <p
                                        style="color:#8892b0;font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:160px;">
                                        {{ $ev->penempatan->klien->nama_perusahaan }}</p>
                                    <p style="color:#3d4263;font-size:0.72rem;">
                                        {{ $ev->penempatan->karyawan->posisi }}</p>
                                </td>
                                {{-- Periode --}}
                                <td>
                                    <span class="valdo-badge valdo-badge-blue" style="font-size:0.7rem;">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $ev->periode)->translatedFormat('M Y') }}
                                    </span>
                                </td>
                                {{-- Tgl Submit --}}
                                <td style="color:#6b7190;font-size:0.82rem;">
                                    {{ $ev->tanggal_diisi_klien ? $ev->tanggal_diisi_klien->format('d M Y') : '—' }}
                                    <p style="font-size:0.7rem;color:#3d4263;">
                                        {{ $ev->tanggal_diisi_klien ? $ev->tanggal_diisi_klien->diffForHumans() : '' }}
                                    </p>
                                </td>
                                {{-- Nilai sementara --}}
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <span
                                            style="font-size:1rem;font-weight:800;color:{{ $nilaiColor }};">{{ $nilaiTemp }}</span>
                                        <div class="valdo-progress" style="width:60px;height:4px;">
                                            <div class="valdo-progress-track {{ $nilaiTemp >= 70 ? 'green' : ($nilaiTemp >= 55 ? 'blue' : 'purple') }}"
                                                style="width:{{ min($nilaiTemp, 100) }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                                {{-- Aksi --}}
                                <td style="text-align:center;">
                                    <button wire:click="bukaModal({{ $ev->id_evaluasi }})"
                                        class="valdo-btn valdo-btn-primary valdo-btn-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                        Review
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="text-align:center;padding:60px 20px;">
                                    <div style="display:flex;flex-direction:column;align-items:center;gap:12px;">
                                        <div
                                            style="width:56px;height:56px;border-radius:16px;background:var(--color-base-400);display:flex;align-items:center;justify-content:center;box-shadow:var(--neu-shadow-md);">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="#34d399"
                                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </div>
                                        <p style="color:#34d399;font-weight:600;">Antrean kosong!</p>
                                        <p class="valdo-text-muted" style="font-size:0.8rem;">Tidak ada penilaian yang
                                            menunggu verifikasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination antrean --}}
                @if ($antrean->hasPages())
                    <div
                        style="padding:14px 20px;border-top:1px solid rgba(255,255,255,0.04);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                        <p class="valdo-text-muted" style="font-size:0.8rem;">
                            Menampilkan {{ $antrean->firstItem() }}–{{ $antrean->lastItem() }} dari
                            {{ $antrean->total() }} antrean
                        </p>
                        {{ $antrean->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ════════════════════════════════════════════
         TAB: RIWAYAT VERIFIKASI
    ════════════════════════════════════════════ --}}
    @elseif ($tab === 'riwayat')
        <div class="valdo-table-wrapper" wire:loading.class="opacity-60"
            wire:target="riwayatSearch,riwayatStatus,riwayatPeriode">

            {{-- Toolbar Riwayat --}}
            <div
                style="padding:16px 20px;border-bottom:1px solid rgba(255,255,255,0.04);display:flex;flex-wrap:wrap;gap:12px;align-items:center;">
                <div class="valdo-search" style="max-width:260px;flex:1;min-width:180px;">
                    <svg class="valdo-search-icon" xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
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
                        @foreach ($opsiPeriodeRiwayat as $p)
                            <option value="{{ $p }}">
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $p)->translatedFormat('F Y') }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Loading shimmer --}}
            <div wire:loading.block wire:target="riwayatSearch,riwayatStatus,riwayatPeriode"
                style="padding:40px 24px;">
                @for ($i = 0; $i < 5; $i++)
                    <div class="valdo-skeleton" style="height:52px;border-radius:8px;margin-bottom:8px;"></div>
                @endfor
            </div>

            <div wire:loading.remove wire:target="riwayatSearch,riwayatStatus,riwayatPeriode">
                <table class="valdo-table" style="min-width:900px;">
                    <thead>
                        <tr>
                            <th>Karyawan</th>
                            <th>Klien</th>
                            <th>Periode</th>
                            <th>Nilai Akhir</th>
                            <th>Status</th>
                            <th>Diverifikasi Oleh</th>
                            <th>Tgl Verifikasi</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $ev)
                            @php
                                $isVerified = $ev->status_evaluasi === 'verified';
                                $nilaiColor =
                                    $ev->total_nilai_akhir >= 70
                                        ? '#34d399'
                                        : ($ev->total_nilai_akhir >= 55
                                            ? '#f59e0b'
                                            : '#f87171');
                            @endphp
                            <tr>
                                <td>
                                    <div style="display:flex;align-items:center;gap:10px;">
                                        <div class="valdo-table-avatar" style="flex-shrink:0;">
                                            {{ strtoupper(substr($ev->penempatan->karyawan->nama_karyawan, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p style="color:#c8ccdc;font-weight:500;font-size:0.875rem;">
                                                {{ $ev->penempatan->karyawan->nama_karyawan }}</p>
                                            <p class="valdo-text-mono" style="font-size:0.72rem;">
                                                {{ $ev->penempatan->karyawan->nik }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="color:#8892b0;font-size:0.85rem;max-width:140px;">
                                    <span
                                        style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;display:block;">{{ $ev->penempatan->klien->nama_perusahaan }}</span>
                                </td>
                                <td>
                                    <span class="valdo-badge valdo-badge-blue" style="font-size:0.7rem;">
                                        {{ \Carbon\Carbon::createFromFormat('Y-m', $ev->periode)->translatedFormat('M Y') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($ev->total_nilai_akhir !== null)
                                        <span
                                            style="font-size:1rem;font-weight:800;color:{{ $nilaiColor }};">{{ number_format($ev->total_nilai_akhir, 1) }}</span>
                                        <span style="color:#3d4263;font-size:0.75rem;">/100</span>
                                    @else
                                        <span class="valdo-text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($isVerified)
                                        <span class="valdo-badge valdo-badge-green">✓ Verified</span>
                                    @else
                                        <span class="valdo-badge valdo-badge-red">✕ Rejected</span>
                                    @endif
                                </td>
                                <td style="color:#8892b0;font-size:0.82rem;">
                                    {{ $ev->verifikator?->name ?? '—' }}
                                </td>
                                <td style="color:#6b7190;font-size:0.8rem;">
                                    {{ $ev->verified_at?->format('d M Y') ?? '—' }}
                                    <p style="font-size:0.7rem;color:#3d4263;">
                                        {{ $ev->verified_at?->diffForHumans() }}</p>
                                </td>
                                <td style="max-width:200px;">
                                    @if ($ev->catatan_verifikator)
                                        <p style="color:#6b7190;font-size:0.78rem;line-height:1.4;white-space:normal;">
                                            {{ Str::limit($ev->catatan_verifikator, 80) }}
                                        </p>
                                    @else
                                        <span class="valdo-text-muted" style="font-size:0.75rem;">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align:center;padding:60px 20px;">
                                    <p class="valdo-text-muted">Belum ada riwayat verifikasi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if ($riwayat->hasPages())
                    <div
                        style="padding:14px 20px;border-top:1px solid rgba(255,255,255,0.04);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px;">
                        <p class="valdo-text-muted" style="font-size:0.8rem;">
                            Menampilkan {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari
                            {{ $riwayat->total() }} riwayat
                        </p>
                        {{ $riwayat->links() }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════════
         MODAL: REVIEW DETAIL PENILAIAN
    ════════════════════════════════════════════════════════ --}}
    @if ($showModal && $evaluasiAktif)
        @php
            $ev = $evaluasiAktif;
            $karyawan = $ev->penempatan->karyawan;
            $klien = $ev->penempatan->klien;

            // Hitung nilai akhir weighted
            $totalBobot = 0;
            $totalNilai = 0;
            foreach ($ev->detail as $d) {
                $b = $d->kriteria->bobot_nilai ?? 1;
                $totalBobot += $b;
                $totalNilai += $d->skor_nilai * $b;
            }
            $nilaiAkhir = $totalBobot > 0 ? round($totalNilai / $totalBobot, 1) : 0;
            $nilaiColor = $nilaiAkhir >= 70 ? '#34d399' : ($nilaiAkhir >= 55 ? '#f59e0b' : '#f87171');
            $rekomendasi = $nilaiAkhir >= 70 ? 'Lanjut Kontrak' : 'Putus Kontrak';
            $rekColor = $nilaiAkhir >= 70 ? 'valdo-badge-cyan' : 'valdo-badge-red';
        @endphp

        {{-- Backdrop --}}
        <div class="valdo-modal-backdrop open" wire:click.self="tutupModal" style="opacity:1;">
            <div class="valdo-modal" style="transform:scale(1);opacity:1;max-width:700px;width:100%;">

                {{-- Modal Header --}}
                <div class="valdo-modal-header">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="valdo-table-avatar"
                            style="width:40px;height:40px;border-radius:12px;font-size:0.875rem;">
                            {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}
                        </div>
                        <div>
                            <p class="valdo-heading-md" style="font-size:1rem;">Review Penilaian</p>
                            <p class="valdo-text-muted" style="font-size:0.78rem;">{{ $karyawan->nama_karyawan }}
                                &bull;
                                {{ \Carbon\Carbon::createFromFormat('Y-m', $ev->periode)->translatedFormat('F Y') }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="tutupModal" class="valdo-modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>

                <div class="valdo-modal-body" style="padding:20px 24px;">

                    {{-- Info Bar --}}
                    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-bottom:20px;">
                        <div
                            style="background:var(--color-base-400);border-radius:10px;padding:12px;border:1px solid rgba(255,255,255,0.05);">
                            <p class="valdo-text-label" style="margin-bottom:4px;">Klien</p>
                            <p style="color:#c8ccdc;font-size:0.82rem;font-weight:500;">
                                {{ Str::limit($klien->nama_perusahaan, 25) }}</p>
                        </div>
                        <div
                            style="background:var(--color-base-400);border-radius:10px;padding:12px;border:1px solid rgba(255,255,255,0.05);">
                            <p class="valdo-text-label" style="margin-bottom:4px;">Tgl Submit Klien</p>
                            <p style="color:#c8ccdc;font-size:0.82rem;font-weight:500;">
                                {{ $ev->tanggal_diisi_klien?->format('d M Y') ?? '—' }}</p>
                        </div>
                        <div
                            style="background:var(--color-base-400);border-radius:10px;padding:12px;border:1px solid rgba(255,255,255,0.05);">
                            <p class="valdo-text-label" style="margin-bottom:4px;">Posisi</p>
                            <p style="color:#c8ccdc;font-size:0.82rem;font-weight:500;">{{ $karyawan->posisi }}</p>
                        </div>
                    </div>

                    {{-- Nilai Akhir + Rekomendasi --}}
                    <div
                        style="display:flex;align-items:center;justify-content:space-between;background:linear-gradient(135deg,rgba(79,142,247,0.08),rgba(139,92,246,0.06));border-radius:14px;padding:16px 20px;border:1px solid rgba(79,142,247,0.15);margin-bottom:20px;">
                        <div>
                            <p class="valdo-text-label" style="margin-bottom:4px;">Estimasi Nilai Akhir (Weighted)</p>
                            <div style="display:flex;align-items:baseline;gap:6px;">
                                <span
                                    style="font-size:2.5rem;font-weight:800;color:{{ $nilaiColor }};line-height:1;">{{ $nilaiAkhir }}</span>
                                <span style="color:#3d4263;font-size:0.85rem;">/100</span>
                            </div>
                        </div>
                        <div style="text-align:right;">
                            <p class="valdo-text-label" style="margin-bottom:6px;">Rekomendasi Sistem</p>
                            <span class="valdo-badge {{ $rekColor }}"
                                style="font-size:0.75rem;">{{ $rekomendasi }}</span>
                        </div>
                    </div>

                    {{-- Rincian Skor Per Kriteria --}}
                    <p class="valdo-text-label" style="margin-bottom:10px;">Rincian Skor Per Kriteria</p>
                    <div style="display:flex;flex-direction:column;gap:8px;margin-bottom:20px;">
                        @foreach ($ev->detail as $d)
                            @php
                                $skor = $d->skor_nilai;
                                $pct = min($skor, 100);
                                $sC = $skor >= 70 ? '#34d399' : ($skor >= 55 ? '#f59e0b' : '#f87171');
                                $tC = $skor >= 70 ? 'green' : ($skor >= 55 ? 'blue' : 'purple');
                            @endphp
                            <div
                                style="background:var(--color-base-400);border-radius:10px;padding:12px 14px;border:1px solid rgba(255,255,255,0.05);">
                                <div
                                    style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                    <div style="display:flex;align-items:center;gap:8px;">
                                        <p style="color:#c8ccdc;font-size:0.85rem;font-weight:500;">
                                            {{ $d->kriteria->nama_kriteria }}</p>
                                        <span
                                            style="font-size:0.68rem;color:#3d4263;background:var(--color-base-300);padding:2px 6px;border-radius:4px;">bobot
                                            {{ $d->kriteria->bobot_nilai }}%</span>
                                    </div>
                                    <span
                                        style="font-size:0.95rem;font-weight:700;color:{{ $sC }};">{{ $skor }}</span>
                                </div>
                                <div class="valdo-progress" style="height:5px;">
                                    <div class="valdo-progress-track {{ $tC }}"
                                        style="width:{{ $pct }}%;"></div>
                                </div>
                            </div>
                        @endforeach
                        @if ($ev->detail->isEmpty())
                            <p class="valdo-text-muted" style="text-align:center;padding:16px 0;">Tidak ada detail
                                kriteria</p>
                        @endif
                    </div>

                    {{-- Komentar Klien --}}
                    @if ($ev->komentar_klien)
                        <div
                            style="background:var(--color-base-200);border-radius:12px;padding:14px 16px;border:1px solid rgba(255,255,255,0.05);border-left:3px solid var(--color-accent-blue);margin-bottom:20px;">
                            <p class="valdo-text-label" style="margin-bottom:6px;">Komentar dari Klien</p>
                            <p style="color:#8892b0;font-size:0.85rem;line-height:1.6;">{{ $ev->komentar_klien }}</p>
                        </div>
                    @endif

                    {{-- Form Catatan Verifikator --}}
                    @if (!$showKonfirmasi)
                        <div class="valdo-input-group" style="margin-bottom:0;">
                            <label class="valdo-label">
                                Catatan Verifikator <span style="color:#ef4444;">*</span>
                            </label>
                            <textarea wire:model="catatanVerifikator" class="valdo-textarea @error('catatanVerifikator') error @enderror"
                                placeholder="Tuliskan catatan sebelum menyetujui atau menolak nilai ini..." rows="3" style="resize:none;"></textarea>
                            @error('catatanVerifikator')
                                <span class="valdo-input-error">{{ $message }}</span>
                            @enderror
                            <p class="valdo-input-hint">Wajib diisi sebelum melakukan aksi approve atau reject.</p>
                        </div>
                    @else
                        {{-- Konfirmasi Panel --}}
                        <div
                            style="background:{{ $aksiKonfirmasi === 'approve' ? 'rgba(52,211,153,0.08)' : 'rgba(239,68,68,0.08)' }};border-radius:12px;padding:16px;border:1px solid {{ $aksiKonfirmasi === 'approve' ? 'rgba(52,211,153,0.2)' : 'rgba(239,68,68,0.2)' }};">
                            <p
                                style="font-weight:600;font-size:0.9rem;color:{{ $aksiKonfirmasi === 'approve' ? '#34d399' : '#f87171' }};margin-bottom:6px;">
                                {{ $aksiKonfirmasi === 'approve' ? '✓ Konfirmasi Persetujuan' : '✕ Konfirmasi Penolakan' }}
                            </p>
                            <p style="color:#8892b0;font-size:0.82rem;line-height:1.5;">
                                @if ($aksiKonfirmasi === 'approve')
                                    Anda akan menyetujui nilai <strong
                                        style="color:#c8ccdc;">{{ $karyawan->nama_karyawan }}</strong> untuk periode
                                    <strong
                                        style="color:#c8ccdc;">{{ \Carbon\Carbon::createFromFormat('Y-m', $ev->periode)->translatedFormat('F Y') }}</strong>.
                                    Nilai akhir <strong
                                        style="color:{{ $nilaiColor }};">{{ $nilaiAkhir }}</strong> akan dicatat
                                    sebagai rekam jejak resmi.
                                @else
                                    Anda akan menolak nilai ini. Klien perlu mengirim ulang penilaian melalui magic link
                                    baru.
                                @endif
                            </p>
                            <div
                                style="margin-top:12px;background:var(--color-base-300);border-radius:8px;padding:10px 12px;">
                                <p class="valdo-text-label" style="margin-bottom:3px;">Catatan yang akan disimpan:</p>
                                <p style="color:#8892b0;font-size:0.82rem;">{{ $catatanVerifikator }}</p>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- Modal Footer --}}
                <div class="valdo-modal-footer">
                    @if (!$showKonfirmasi)
                        <button wire:click="batalKonfirmasi" class="valdo-btn valdo-btn-ghost">Tutup</button>
                        <button wire:click="konfirmasiAksi('reject')" class="valdo-btn valdo-btn-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            Tolak Nilai
                        </button>
                        <button wire:click="konfirmasiAksi('approve')" class="valdo-btn valdo-btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                            Setujui Nilai
                        </button>
                    @else
                        {{-- Tombol eksekusi akhir --}}
                        <button wire:click="batalKonfirmasi" class="valdo-btn valdo-btn-ghost">← Kembali Edit</button>
                        @if ($aksiKonfirmasi === 'approve')
                            <button wire:click="approve" wire:loading.attr="disabled" wire:target="approve"
                                class="valdo-btn valdo-btn-primary">
                                <span wire:loading.remove wire:target="approve">✓ Ya, Setujui Sekarang</span>
                                <span wire:loading wire:target="approve">Menyimpan...</span>
                            </button>
                        @else
                            <button wire:click="reject" wire:loading.attr="disabled" wire:target="reject"
                                class="valdo-btn valdo-btn-danger">
                                <span wire:loading.remove wire:target="reject">✕ Ya, Tolak Sekarang</span>
                                <span wire:loading wire:target="reject">Menyimpan...</span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════════
         MODAL: KONFIRMASI BULK APPROVE
    ════════════════════════════════════════════ --}}
    @if ($showBulkKonfirmasi)
        <div class="valdo-modal-backdrop open" wire:click.self="$set('showBulkKonfirmasi', false)"
            style="opacity:1;">
            <div class="valdo-modal" style="transform:scale(1);opacity:1;max-width:460px;">
                <div class="valdo-modal-header">
                    <div style="display:flex;align-items:center;gap:10px;">
                        <div
                            style="width:36px;height:36px;border-radius:10px;background:rgba(79,142,247,0.15);display:flex;align-items:center;justify-content:center;color:var(--color-accent-blue);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                                <polyline points="22 4 12 14.01 9 11.01" />
                            </svg>
                        </div>
                        <p class="valdo-heading-md" style="font-size:1rem;">Verifikasi Massal</p>
                    </div>
                    <button wire:click="$set('showBulkKonfirmasi', false)" class="valdo-modal-close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18" />
                            <line x1="6" y1="6" x2="18" y2="18" />
                        </svg>
                    </button>
                </div>
                <div class="valdo-modal-body">
                    <div style="text-align:center;padding:16px 0;">
                        <div style="font-size:3rem;margin-bottom:12px;">⚡</div>
                        <p style="color:#c8ccdc;font-size:1rem;font-weight:600;margin-bottom:8px;">
                            Verifikasi <span style="color:var(--color-accent-blue);">{{ count($selected) }}</span>
                            evaluasi sekaligus?
                        </p>
                        <p style="color:#6b7190;font-size:0.85rem;line-height:1.6;">
                            Semua evaluasi yang dipilih akan otomatis berstatus <strong
                                style="color:#34d399;">Verified</strong> dengan catatan "Disetujui secara massal oleh
                            manajemen." Aksi ini tidak bisa dibatalkan.
                        </p>
                    </div>
                </div>
                <div class="valdo-modal-footer">
                    <button wire:click="$set('showBulkKonfirmasi', false)"
                        class="valdo-btn valdo-btn-ghost">Batal</button>
                    <button wire:click="bulkApprove" wire:loading.attr="disabled" wire:target="bulkApprove"
                        class="valdo-btn valdo-btn-primary">
                        <span wire:loading.remove wire:target="bulkApprove">
                            ✓ Verifikasi {{ count($selected) }} Data
                        </span>
                        <span wire:loading wire:target="bulkApprove">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
