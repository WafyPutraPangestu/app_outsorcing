<div x-data="{ confirmDelete: false, deleteId: null, deleteName: '' }">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
        <div>
            <h1 class="valdo-heading-lg valdo-glow-blue">Kriteria Penilaian</h1>
            <p class="valdo-text-muted mt-1">Kelola parameter dan bobot evaluasi kinerja karyawan.</p>
        </div>
        <a href="{{ route('admin.kriteria.create') }}" wire:navigate
            class="valdo-btn valdo-btn-primary valdo-btn-lg shadow-neu-lg hover:-translate-y-1 transition-transform">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kriteria
        </a>
    </div>

    <!-- Flash Message: Sukses -->
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

    {{-- Flash Message: Gagal (misal kriteria masih dipakai di evaluasi) --}}
    @if (session()->has('error'))
        <div class="valdo-toast error mb-6 animate-[valdo-toast-in_0.3s_ease-out]"
            style="position: relative; right: auto; bottom: auto; max-width: 100%;">
            <div class="valdo-toast-icon"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg></div>
            <div class="valdo-toast-content">
                <div class="valdo-toast-title">Gagal</div>
                <div class="valdo-toast-message">{{ session('error') }}</div>
            </div>
        </div>
    @endif

    <!-- Indikator Total Bobot -->
    @php $total = $this->totalBobotAktif; @endphp
    <div
        class="valdo-card {{ $total == 100 ? 'border-emerald-500/30 bg-emerald-500/5' : 'border-red-500/30 bg-red-500/5 valdo-float' }} mb-8 p-6 flex flex-col md:flex-row items-center justify-between gap-4 transition-all duration-500">
        <div class="flex items-center gap-4">
            <div
                class="w-14 h-14 rounded-full flex items-center justify-center {{ $total == 100 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400 animate-pulse' }}">
                @if ($total == 100)
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @else
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                @endif
            </div>
            <div>
                <h3 class="text-black font-bold text-lg">Total Bobot Kriteria Aktif</h3>
                <p class="{{ $total == 100 ? 'text-emerald-400/80' : 'text-red-400/80' }} text-sm">
                    {{ $total == 100 ? 'Kondisi ideal terpenuhi. Sistem siap digunakan.' : 'Peringatan: Total bobot harus tepat 100 agar evaluasi akurat.' }}
                </p>
            </div>
        </div>
        <div class="text-4xl font-black {{ $total == 100 ? 'text-emerald-400' : 'text-red-400' }}">
            {{ (float) $total }}<span class="text-xl">%</span>
        </div>
    </div>

    <!-- Tabel Data Kriteria -->
    <div class="valdo-card valdo-card-glow-purple p-0">
        <div class="p-6 border-b border-white/5">
            <h2 class="valdo-heading-md">Daftar Parameter Evaluasi</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="valdo-table w-full">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Kriteria</th>
                        <th>Bobot Nilai</th>
                        <th class="text-center">Status Aktif</th>
                        <th class="text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kriterias as $kriteria)
                        <tr class="group hover:bg-base-400/30 transition-colors">
                            <td class="text-gray-500 font-mono text-xs">#{{ $kriteria->id_kriteria }}</td>
                            <td>
                                <div class="font-bold text-black">{{ $kriteria->nama_kriteria }}</div>
                            </td>
                            <td>
                                <span
                                    class="valdo-badge {{ $kriteria->is_aktif ? 'valdo-badge-purple' : 'valdo-badge-muted' }}">
                                    {{ (float) $kriteria->bobot_nilai }}%
                                </span>
                            </td>
                            <td class="text-center">
                                <!-- Valdo Toggle Switch -->
                                <label class="valdo-toggle inline-block" title="Ubah Status">
                                    <input type="checkbox" wire:click="toggleStatus({{ $kriteria->id_kriteria }})"
                                        {{ $kriteria->is_aktif ? 'checked' : '' }}>
                                    <div class="valdo-toggle-track"></div>
                                </label>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.kriteria.show', $kriteria->id_kriteria) }}" wire:navigate
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
                                    <a href="{{ route('admin.kriteria.edit', $kriteria->id_kriteria) }}" wire:navigate
                                        class="valdo-btn valdo-btn-sm valdo-btn-ghost text-accent-blue hover:text-black"
                                        title="Edit Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus: buka modal konfirmasi Alpine, belum eksekusi apapun --}}
                                    <button type="button"
                                        @click="deleteId = {{ $kriteria->id_kriteria }}; deleteName = '{{ addslashes($kriteria->nama_kriteria) }}'; confirmDelete = true"
                                        class="valdo-btn valdo-btn-sm valdo-btn-ghost text-red-400 hover:text-black"
                                        title="Hapus Data">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-12 text-gray-500">
                                Belum ada kriteria penilaian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-white/5">
            {{ $kriterias->links() }}
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         MODAL KONFIRMASI HAPUS (Alpine.js murni)
    ══════════════════════════════════════════ --}}
    <div x-show="confirmDelete" x-cloak x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-1"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-1"
        x-transition:leave-end="opacity-0" class="valdo-modal-backdrop open"
        @keydown.escape.window="confirmDelete = false">
        <div class="valdo-modal" style="max-width: 420px;" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-1 scale-100">
            <div class="valdo-modal-header">
                <div style="display:flex;align-items:center;gap:10px;">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:rgba(239,68,68,0.15);display:flex;align-items:center;justify-content:center;color:#f87171;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <p class="valdo-heading-md" style="font-size:1rem;">Hapus Kriteria?</p>
                </div>
                <button @click="confirmDelete = false" class="valdo-modal-close">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        stroke-width="2.5">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>
            <div class="valdo-modal-body">
                <p style="color:#8892b0;font-size:0.9rem;line-height:1.6;">
                    Anda akan menghapus kriteria <strong style="color:#c8ccdc;" x-text="deleteName"></strong>.
                    Tindakan ini tidak bisa dibatalkan. Kriteria yang sudah pernah dipakai untuk menilai
                    karyawan tidak akan bisa dihapus.
                </p>
            </div>
            <div class="valdo-modal-footer">
                <button type="button" @click="confirmDelete = false" class="valdo-btn valdo-btn-ghost">
                    Batal
                </button>
                <button type="button" @click="$wire.hapus(deleteId); confirmDelete = false"
                    class="valdo-btn valdo-btn-danger">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>

</div>
