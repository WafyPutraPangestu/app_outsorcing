<div>

    <div class="mb-6">
        <a href="{{ route('admin.klien.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Klien
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <div class="valdo-card valdo-card-glow-blue">
            <div class="valdo-card-header">
                <div>
                    <h2 class="valdo-heading-lg">Tambah Klien Baru</h2>
                    <p class="valdo-text-muted mt-1">Masukkan informasi perusahaan mitra dengan lengkap.</p>
                </div>
            </div>

            <form wire:submit.prevent="save">
                <div class="valdo-input-group">
                    <label class="valdo-label">Nama Perusahaan <span class="text-red-400">*</span></label>
                    <input type="text" wire:model="nama_perusahaan"
                        class="valdo-input @error('nama_perusahaan') error @enderror"
                        placeholder="Contoh: PT Bank Sejahtera Tbk">
                    @error('nama_perusahaan')
                        <span class="valdo-input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="valdo-input-group">
                        <label class="valdo-label">Email HRD Klien <span class="text-red-400">*</span></label>
                        <input type="email" wire:model="email_hrd_klien"
                            class="valdo-input @error('email_hrd_klien') error @enderror"
                            placeholder="hrd@perusahaan.com">
                        @error('email_hrd_klien')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                        <span class="valdo-input-hint">Email ini digunakan untuk mengirim Magic Link.</span>
                    </div>

                    <div class="valdo-input-group">
                        <label class="valdo-label">Nama Kontak Person</label>
                        <input type="text" wire:model="nama_kontak_person"
                            class="valdo-input @error('nama_kontak_person') error @enderror"
                            placeholder="Nama staff HR/Manager">
                        @error('nama_kontak_person')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="valdo-input-group mb-8">
                    <label class="valdo-label">Alamat Kantor</label>
                    <textarea wire:model="alamat_kantor" class="valdo-textarea @error('alamat_kantor') error @enderror"
                        placeholder="Alamat lengkap perusahaan klien..."></textarea>
                    @error('alamat_kantor')
                        <span class="valdo-input-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end gap-3">
                    <a href="{{ route('admin.klien.index') }}" wire:navigate
                        class="valdo-btn valdo-btn-secondary">Batal</a>
                    <button type="submit" class="valdo-btn valdo-btn-primary" wire:loading.class="loading">
                        <span wire:loading.remove>Simpan Data Klien</span>
                        <span wire:loading>Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
