<div>

    <div class="mb-6">
        <a href="{{ route('admin.kriteria.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Kriteria
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="valdo-card valdo-card-glow-purple">
            <div class="valdo-card-header border-b border-white/5 pb-4 mb-6">
                <div>
                    <h2 class="valdo-heading-lg">Edit Kriteria</h2>
                    <p class="valdo-text-muted mt-1">Perbarui detail kriteria <span
                            class="text-accent-cyan">{{ $kriteria->nama_kriteria }}</span></p>
                </div>
            </div>

            <form wire:submit.prevent="update">
                <div class="valdo-input-group mb-4">
                    <label class="valdo-label">Nama Kriteria <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="nama_kriteria"
                        class="valdo-input @error('nama_kriteria') error @enderror">
                    @error('nama_kriteria')
                        <span class="valdo-input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="valdo-input-group mb-6">
                    <label class="valdo-label">Bobot Nilai (%) <span class="text-red-400">*</span></label>
                    <div class="valdo-input-wrapper">
                        <input type="number" step="0.01" wire:model="bobot_nilai"
                            class="valdo-input pl-4 pr-10 @error('bobot_nilai') error @enderror">
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold">%</div>
                    </div>
                    @error('bobot_nilai')
                        <span class="valdo-input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div
                    class="valdo-input-group mb-8 p-4 bg-base-200 rounded-xl border border-white/5 flex items-center justify-between shadow-neu-inset">
                    <div>
                        <label class="valdo-label text-white block mb-1">Status Kriteria</label>
                        <span class="text-xs text-gray-500">Matikan jika tidak ingin digunakan sementara waktu.</span>
                    </div>
                    <label class="valdo-toggle">
                        <input type="checkbox" wire:model="is_aktif">
                        <div class="valdo-toggle-track"></div>
                    </label>
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end gap-3">
                    <a href="{{ route('admin.kriteria.index') }}" wire:navigate
                        class="valdo-btn valdo-btn-secondary">Batal</a>
                    <button type="submit" class="valdo-btn valdo-btn-primary" wire:loading.class="loading">
                        <span wire:loading.remove>Simpan Perubahan</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
