<div>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="valdo-heading-lg valdo-glow-blue">Penempatan Kerja</h1>
            <p class="valdo-text-muted mt-1">Kelola data penugasan karyawan ke perusahaan klien.</p>
        </div>
        <a href="{{ route('admin.penempatan.create') }}" wire:navigate
            class="valdo-btn valdo-btn-primary valdo-btn-lg shadow-neu-lg hover:-translate-y-1 transition-transform">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Penempatan
        </a>
    </div>

    <!-- Flash Message -->
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

    <!-- Tabel Data Penempatan -->
    <div class="valdo-card valdo-card-glow-blue p-0">
        <div class="p-6 border-b border-white/5 flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="valdo-heading-md">Daftar Kontrak Kerja</h2>
            <div class="valdo-search w-full sm:w-auto">
                <svg class="w-5 h-5 valdo-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" wire:model.live.debounce.500ms="search" class="valdo-search-input"
                    placeholder="Cari karyawan atau klien...">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="valdo-table w-full">
                <thead>
                    <tr>
                        <th>Karyawan</th>
                        <th>Klien / Perusahaan</th>
                        <th>Periode Kontrak</th>
                        <th class="text-center">Status</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penempatans as $penempatan)
                        <tr class="group hover:bg-base-400/30 transition-colors">
                            <td>
                                <div class="font-bold text-black">{{ $penempatan->karyawan->nama_karyawan }}</div>
                                <div class="text-xs text-gray-500 font-mono mt-0.5">NIK:
                                    {{ $penempatan->karyawan->nik }}</div>
                            </td>
                            <td>
                                <div class="text-accent-cyan font-medium">{{ $penempatan->klien->nama_perusahaan }}
                                </div>
                            </td>
                            <td>
                                <div class="text-sm text-gray-300 flex items-center gap-2">
                                    <span>{{ $penempatan->tanggal_mulai->format('d M Y') }}</span>
                                    <svg class="w-3 h-3 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                    <span>{{ $penempatan->tanggal_selesai ? $penempatan->tanggal_selesai->format('d M Y') : 'Sekarang' }}</span>
                                </div>
                            </td>
                            <td class="text-center">
                                @if ($penempatan->status_aktif)
                                    <span class="valdo-badge valdo-badge-green"><span
                                            class="w-2 h-2 rounded-full bg-emerald-400 mr-1 animate-pulse"></span>
                                        Aktif</span>
                                @else
                                    <span class="valdo-badge valdo-badge-muted">Selesai</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div
                                    class="flex justify-end gap-2 opacity-100 sm:opacity-100 sm:group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.penempatan.show', $penempatan->id_penempatan) }}"
                                        wire:navigate
                                        class="valdo-btn valdo-btn-sm valdo-btn-ghost text-accent-cyan hover:text-black"
                                        title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.penempatan.edit', $penempatan->id_penempatan) }}"
                                        wire:navigate
                                        class="valdo-btn valdo-btn-sm valdo-btn-ghost text-accent-blue hover:text-black"
                                        title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>
                                    <button wire:click="delete({{ $penempatan->id_penempatan }})"
                                        wire:confirm="Yakin ingin menghapus data penempatan ini?"
                                        class="valdo-btn valdo-btn-sm valdo-btn-ghost text-red-400 hover:text-black"
                                        title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                Belum ada data penempatan kerja.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-white/5">
            {{ $penempatans->links() }}
        </div>
    </div>
</div>
