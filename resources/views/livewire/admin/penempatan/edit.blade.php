<div>

    <div class="mb-6">
        <a href="{{ route('admin.penempatan.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Penempatan
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <div class="valdo-card valdo-card-glow-purple">
            <div class="valdo-card-header border-b border-white/5 pb-4 mb-6">
                <div>
                    <h2 class="valdo-heading-lg">Edit Penempatan Kerja</h2>
                    <p class="valdo-text-muted mt-1">Perbarui detail kontrak kerja karyawan di perusahaan klien.</p>
                </div>
            </div>

            <form wire:submit.prevent="update">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="valdo-input-group">
                        <label class="valdo-label">Pilih Karyawan <span class="text-red-400">*</span></label>
                        <div class="valdo-select-wrapper">
                            <select wire:model="id_karyawan" class="valdo-select @error('id_karyawan') error @enderror">
                                <option value="">-- Pilih Karyawan --</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama_karyawan }} (NIK:
                                        {{ $karyawan->nik }})</option>
                                @endforeach
                            </select>
                        </div>
                        @error('id_karyawan')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="valdo-input-group">
                        <label class="valdo-label">Pilih Klien / Perusahaan <span class="text-red-400">*</span></label>
                        <div class="valdo-select-wrapper">
                            <select wire:model="id_klien" class="valdo-select @error('id_klien') error @enderror">
                                <option value="">-- Pilih Perusahaan Klien --</option>
                                @foreach ($kliens as $klien)
                                    <option value="{{ $klien->id_klien }}">{{ $klien->nama_perusahaan }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('id_klien')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="valdo-input-group">
                        <label class="valdo-label">Tanggal Mulai Kontrak <span class="text-red-400">*</span></label>
                        <input type="date" wire:model="tanggal_mulai"
                            class="valdo-input @error('tanggal_mulai') error @enderror">
                        @error('tanggal_mulai')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="valdo-input-group">
                        <label class="valdo-label">Tanggal Selesai Kontrak</label>
                        <input type="date" wire:model="tanggal_selesai"
                            class="valdo-input @error('tanggal_selesai') error @enderror">
                        @error('tanggal_selesai')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div
                    class="valdo-input-group mb-8 p-4 bg-base-200 rounded-xl border border-white/5 flex items-center justify-between shadow-neu-inset">
                    <div>
                        <label class="valdo-label text-white block mb-1">Status Penempatan</label>
                        <span class="text-xs text-gray-500">Ubah menjadi tidak aktif jika kontrak sudah berakhir atau
                            diputus.</span>
                    </div>
                    <label class="valdo-toggle">
                        <input type="checkbox" wire:model="status_aktif">
                        <div class="valdo-toggle-track"></div>
                    </label>
                </div>

                <div class="pt-6 border-t border-white/5 flex justify-end gap-3">
                    <a href="{{ route('admin.penempatan.index') }}" wire:navigate
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
