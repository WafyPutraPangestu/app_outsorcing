<div x-data="{ modalOpen: false }">

    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="valdo-heading-lg valdo-glow-blue">Manajemen Evaluasi</h1>
            <p class="valdo-text-muted mt-1">Pantau dan verifikasi hasil evaluasi kinerja bulanan dari klien.</p>
        </div>

        <!-- Tombol Buka Modal Generate Link -->
        <button @click="modalOpen = true"
            class="valdo-btn valdo-btn-primary valdo-btn-lg shadow-neu-lg hover:-translate-y-1 transition-transform">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                </path>
            </svg>
            Buat Magic Link
        </button>
    </div>

    <!-- Flash Message Alert -->
    @if (session()->has('message'))
        <div class="valdo-toast success mb-6 animate-[valdo-toast-in_0.3s_ease-out]"
            style="position: relative; right: auto; bottom: auto; max-width: 100%;">
            <div class="valdo-toast-icon"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg></div>
            <div class="valdo-toast-content">
                <div class="valdo-toast-title">Berhasil</div>
                <div class="valdo-toast-message">{{ session('message') }}</div>
            </div>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="valdo-toast error mb-6 animate-[valdo-toast-in_0.3s_ease-out]"
            style="position: relative; right: auto; bottom: auto; max-width: 100%;">
            <div class="valdo-toast-icon"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg></div>
            <div class="valdo-toast-content">
                <div class="valdo-toast-title">Gagal</div>
                <div class="valdo-toast-message">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- Tabel Data Evaluasi -->
    <div class="valdo-card valdo-card-glow-blue p-0">
        <div class="p-6 border-b border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="valdo-heading-md">Daftar Evaluasi Bulanan</h2>
            <div class="valdo-search w-full sm:w-auto">
                <svg class="w-5 h-5 valdo-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" wire:model.live.debounce.500ms="search" class="valdo-search-input"
                    placeholder="Cari periode atau status...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="valdo-table w-full">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Karyawan</th>
                        <th>Klien</th>
                        <th>Skor Akhir</th>
                        <th>Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($evaluasis as $eval)
                        <tr class="group hover:bg-base-400/30 transition-colors">
                            <td>
                                <span class="valdo-badge valdo-badge-blue">{{ $eval->periode }}</span>
                            </td>
                            <td>
                                <div class="font-semibold text-white">{{ $eval->penempatan->karyawan->nama_karyawan }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-400">{{ $eval->penempatan->klien->nama_perusahaan }}</div>
                            </td>
                            <td>
                                @if ($eval->total_nilai_akhir)
                                    <span
                                        class="font-bold text-accent-cyan text-lg">{{ $eval->total_nilai_akhir }}</span>
                                @else
                                    <span class="text-gray-600 italic">-</span>
                                @endif
                            </td>
                            <td>
                                @if ($eval->status_evaluasi == 'menunggu_klien')
                                    <span class="valdo-badge valdo-badge-muted"><span
                                            class="w-2 h-2 rounded-full bg-gray-400 mr-1 animate-pulse"></span> Menunggu
                                        Klien</span>
                                @elseif($eval->status_evaluasi == 'menunggu_verifikasi')
                                    <span class="valdo-badge valdo-badge-cyan"><span
                                            class="w-2 h-2 rounded-full bg-cyan-400 mr-1 animate-pulse"></span> Perlu
                                        Verifikasi</span>
                                @elseif($eval->status_evaluasi == 'verified')
                                    <span class="valdo-badge valdo-badge-green"><svg class="w-3 h-3 inline mr-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg> Verified</span>
                                @else
                                    <span class="valdo-badge valdo-badge-red"><svg class="w-3 h-3 inline mr-1"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg> Ditolak</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.evaluasi.show', $eval->id_evaluasi) }}" wire:navigate
                                    class="valdo-btn valdo-btn-sm valdo-btn-secondary inline-flex">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-12">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-16 h-16 mb-4 text-gray-600 opacity-50" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    <p class="text-lg font-medium">Belum ada data evaluasi</p>
                                    <p class="text-sm mt-1">Buat magic link untuk mulai mengirim form ke klien.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-white/5">
            {{ $evaluasis->links() }}
        </div>
    </div>

    <!-- MODAL: Generate Magic Link (Menggunakan Alpine.js) -->
    <div x-cloak x-show="modalOpen" class="valdo-modal-backdrop open" style="display: none;">
        <div class="valdo-modal" @click.away="modalOpen = false" x-show="modalOpen" x-transition:enter="valdo-enter"
            x-transition:enter-start="valdo-enter-start" x-transition:enter-end="valdo-enter-end"
            x-transition:leave="valdo-leave" x-transition:leave-start="valdo-leave-start"
            x-transition:leave-end="valdo-leave-end">
            <div class="valdo-modal-header">
                <h3 class="valdo-heading-md text-white">Buat Magic Link Baru</h3>
                <button @click="modalOpen = false" class="valdo-modal-close"><svg class="w-5 h-5" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg></button>
            </div>
            <div class="valdo-modal-body">
                <p class="valdo-text-muted mb-6">Pilih karyawan yang sedang aktif di penempatan untuk dibuatkan token
                    evaluasi bulan ini.</p>

                <div class="space-y-3 max-h-[60vh] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($penempatanAktif as $p)
                        <div
                            class="flex items-center justify-between p-4 bg-base-200 rounded-xl border border-white/5 hover:border-accent-blue/50 transition-colors group">
                            <div>
                                <h4 class="font-bold text-white text-sm">{{ $p->karyawan->nama_karyawan }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Klien: {{ $p->klien->nama_perusahaan }}</p>
                            </div>
                            <button wire:click="generateMagicLink({{ $p->id_penempatan }})"
                                @click="modalOpen = false"
                                class="valdo-btn valdo-btn-sm valdo-btn-primary opacity-0 group-hover:opacity-100 transition-opacity">
                                Kirim Link
                            </button>
                        </div>
                    @empty
                        <div class="text-center p-6 bg-base-200 rounded-xl border border-white/5">
                            <p class="text-gray-500 text-sm">Tidak ada karyawan yang sedang berstatus aktif di
                                penempatan saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
