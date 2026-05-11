<div>

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <p class="valdo-text-label mb-1">Master Data</p>
            <h1 class="valdo-heading-lg">Manajemen Karyawan</h1>
            <p class="valdo-text-muted mt-1">Kelola seluruh data karyawan PT Valdo</p>
        </div>
        <a href="{{ route('admin.karyawan.create') }}" wire:navigate class="valdo-btn valdo-btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14M12 5l7 7-7 7" />
            </svg>
            Tambah Karyawan
        </a>
    </div>

    {{-- ── FLASH MESSAGE ── --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2" class="valdo-toast success mb-6 pointer-events-auto"
            style="position:relative; max-width:100%;">
            <div class="valdo-toast-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
            </div>
            <div class="valdo-toast-content">
                <p class="valdo-toast-title">Berhasil!</p>
                <p class="valdo-toast-message">{{ session('message') }}</p>
            </div>
            <button @click="show = false" class="valdo-modal-close" style="margin-left:auto; flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    @endif

    {{-- ── STAT CARDS ── --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        @php
            $totalKaryawan = \App\Models\Karyawan::count();
            $aktif = \App\Models\Karyawan::where('status_karyawan', 'aktif')->count();
            $nonaktif = \App\Models\Karyawan::where('status_karyawan', 'nonaktif')->count();
        @endphp
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon blue">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $totalKaryawan }}</div>
            <div class="valdo-stat-label">Total Karyawan</div>
        </div>
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon cyan">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $aktif }}</div>
            <div class="valdo-stat-label">Karyawan Aktif</div>
            <span class="valdo-stat-trend up">
                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="18 15 12 9 6 15" />
                </svg>
                Aktif
            </span>
        </div>
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon pink">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $nonaktif }}</div>
            <div class="valdo-stat-label">Karyawan Nonaktif</div>
        </div>
    </div>

    {{-- ── TABLE CARD ── --}}
    <div class="valdo-table-wrapper">
        {{-- Table Toolbar --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 px-5 py-4"
            style="border-bottom: 1px solid rgba(255,255,255,0.04);">
            <div class="valdo-heading-md" style="font-size:1rem;">Daftar Karyawan</div>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                {{-- Search --}}
                <div class="valdo-search" style="max-width:280px; flex:1;">
                    <svg class="valdo-search-icon" xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input wire:model.live.debounce.300ms="search" type="text" class="valdo-search-input"
                        placeholder="Cari nama atau NIK...">
                </div>
                {{-- Per Page --}}
                <div class="valdo-select-wrapper" style="flex-shrink:0;">
                    <select wire:model.live="perPage" class="valdo-select" style="width:auto; padding-right:32px;">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Livewire Loading Overlay --}}
        <div wire:loading.flex class="items-center justify-center py-12" style="display:none;">
            <div class="flex flex-col items-center gap-3">
                <div class="valdo-loader-dots">
                    <div class="valdo-loader-dot"></div>
                    <div class="valdo-loader-dot"></div>
                    <div class="valdo-loader-dot"></div>
                </div>
                <span class="valdo-text-muted text-xs">Memuat data...</span>
            </div>
        </div>

        {{-- Table --}}
        <div wire:loading.remove>
            <table class="valdo-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>NIK</th>
                        <th>Nama Karyawan</th>
                        <th>Posisi</th>
                        <th>Status</th>
                        <th style="text-align:right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($karyawans as $index => $k)
                        <tr>
                            <td class="valdo-text-muted" style="font-size:0.8rem;">
                                {{ $karyawans->firstItem() + $index }}
                            </td>
                            <td>
                                <span class="valdo-text-mono">{{ $k->nik }}</span>
                            </td>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="valdo-table-avatar" style="flex-shrink:0;">
                                        {{ strtoupper(substr($k->nama_karyawan, 0, 2)) }}
                                    </div>
                                    <span style="color:#c8ccdc; font-weight:500;">{{ $k->nama_karyawan }}</span>
                                </div>
                            </td>
                            <td>
                                <span style="color:#8892b0;">{{ $k->posisi }}</span>
                            </td>
                            <td>
                                @if ($k->status_karyawan === 'aktif')
                                    <span class="valdo-badge valdo-badge-green">
                                        <span
                                            style="width:5px;height:5px;border-radius:50%;background:#34d399;display:inline-block;"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="valdo-badge valdo-badge-muted">
                                        <span
                                            style="width:5px;height:5px;border-radius:50%;background:#6b7190;display:inline-block;"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-2">
                                    {{-- Detail --}}
                                    <a href="{{ route('admin.karyawan.show', $k->id_karyawan) }}" wire:navigate
                                        class="valdo-icon-btn" title="Lihat Detail"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.karyawan.edit', $k->id_karyawan) }}" wire:navigate
                                        class="valdo-icon-btn" title="Edit"
                                        style="width:32px;height:32px;border-radius:8px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>
                                    {{-- Delete --}}
                                    <button x-data
                                        @click="if(confirm('Hapus karyawan {{ addslashes($k->nama_karyawan) }}? Data akan dipindahkan ke trash.')) $wire.delete({{ $k->id_karyawan }})"
                                        class="valdo-icon-btn" title="Hapus"
                                        style="width:32px;height:32px;border-radius:8px;color:#f87171;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6" />
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                            <path d="M10 11v6M14 11v6" />
                                            <path d="M9 6V4h6v2" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:60px 20px;">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        style="width:56px;height:56px;border-radius:16px;background:var(--color-base-400);display:flex;align-items:center;justify-content:center;box-shadow:var(--neu-shadow-md);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="#3d4263" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                            <circle cx="9" cy="7" r="4" />
                                        </svg>
                                    </div>
                                    <p class="valdo-text-muted">Tidak ada data karyawan ditemukan</p>
                                    @if ($search)
                                        <button wire:click="$set('search', '')"
                                            class="valdo-btn valdo-btn-ghost valdo-btn-sm">
                                            Reset Pencarian
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            @if ($karyawans->hasPages())
                <div class="flex items-center justify-between px-5 py-4"
                    style="border-top:1px solid rgba(255,255,255,0.04);">
                    <p class="valdo-text-muted" style="font-size:0.8rem;">
                        Menampilkan {{ $karyawans->firstItem() }}–{{ $karyawans->lastItem() }}
                        dari {{ $karyawans->total() }} karyawan
                    </p>
                    <div class="valdo-pagination">
                        {{ $karyawans->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

</div>
