<div>
    <!-- CEK KONDISI: Apakah form valid untuk ditampilkan? -->
    @if (!$isValid)
        <!-- TAMPILAN 1: Pesan Error atau Pesan Sukses -->
        <div class="valdo-card valdo-card-glow-blue text-center p-10 max-w-lg mx-auto mt-10">
            @if (session()->has('message'))
                <!-- Jika Klien baru saja berhasil submit -->
                <div class="mb-6 flex justify-center">
                    <div
                        class="w-16 h-16 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                </div>
                <h2 class="valdo-heading-lg mb-2 text-black">Sukses!</h2>
                <p class="text-gray-400">{{ session('message') }}</p>
            @else
                <!-- Jika token hangus, kadaluarsa, atau salah -->
                <div class="mb-6 flex justify-center">
                    <div class="w-16 h-16 rounded-full bg-red-500/20 flex items-center justify-center text-red-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                </div>
                <h2 class="valdo-heading-lg mb-2 text-black">Akses Ditolak</h2>
                <p class="text-gray-400">{{ $pesanError }}</p>
            @endif
        </div>
    @else
        <!-- TAMPILAN 2: Form Evaluasi (Jika Token Valid) -->
        <div class="valdo-card max-w-3xl mx-auto mt-6">

            <!-- Bagian Header Form -->
            <div
                class="valdo-card-header flex-col items-center justify-center text-center pb-6 border-b border-white/5">
                <div class="valdo-logo-3d mb-4 transform scale-75">
                    <div class="valdo-logo-3d-inner">
                        <div class="valdo-logo-face front">V</div>
                        <div class="valdo-logo-face back">V</div>
                    </div>
                </div>
                <h1 class="valdo-heading-lg">Evaluasi Kinerja Bulanan</h1>
                <p class="valdo-text-muted mt-1">Sistem Outsourcing PT Valdo</p>
            </div>

            <!-- Informasi Karyawan & Periode -->
            <div class="bg-base-200 rounded-xl p-5 mb-8 border border-white/5 shadow-neu-inset">
                <div class="flex justify-between items-center mb-4 pb-4 border-b border-white/5">
                    <span class="valdo-text-label">Periode Evaluasi</span>
                    <span class="valdo-badge valdo-badge-blue">{{ $tokenData->evaluasi->periode }}</span>
                </div>

                <div>
                    <span class="valdo-text-label block mb-1">Karyawan yang Dievaluasi</span>
                    <h3 class="text-xl font-bold text-black">
                        {{ $tokenData->evaluasi->penempatan->karyawan->nama_karyawan }}</h3>
                    <p class="text-accent-cyan text-sm">{{ $tokenData->evaluasi->penempatan->karyawan->posisi }}</p>
                </div>
            </div>

            <!-- Form Pengisian Nilai -->
            <form wire:submit.prevent="save">
                <div class="mb-8">
                    <h3 class="valdo-text-label mb-4 text-black">Form Penilaian (Skala 0 - 100)</h3>

                    <div class="space-y-5">
                        <!-- Melakukan perulangan untuk setiap kriteria yang aktif -->
                        @foreach ($kriteriaList as $kriteria)
                            <div
                                class="valdo-input-group p-4 bg-base-200 rounded-xl border border-white/5 transition-normal hover:border-accent-blue/30">
                                <label class="valdo-label flex justify-between w-full mb-2">
                                    <span class="text-black">{{ $kriteria->nama_kriteria }}</span>
                                    <span class="text-gray-500 font-normal">Bobot:
                                        {{ (int) $kriteria->bobot_nilai }}%</span>
                                </label>

                                <!-- Input nilai yang dihubungkan dengan array $skor di backend -->
                                <input type="number" wire:model="skor.{{ $kriteria->id_kriteria }}"
                                    class="valdo-input @error('skor.' . $kriteria->id_kriteria) error @enderror"
                                    placeholder="Masukkan nilai 0 sampai 100" min="0" max="100">
                                @error('skor.' . $kriteria->id_kriteria)
                                    <span class="valdo-input-error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kolom Komentar Klien -->
                <div class="valdo-input-group mb-8">
                    <label class="valdo-label text-black mb-2">Komentar / Feedback Klien (Opsional)</label>
                    <textarea wire:model="komentar_klien" class="valdo-textarea"
                        placeholder="Tuliskan catatan, saran, atau evaluasi tambahan Anda di sini..."></textarea>
                    @error('komentar_klien')
                        <span class="valdo-input-error">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Submit dengan efek loading bawaan Livewire -->
                <div class="pt-6 border-t border-white/5 text-right">
                    <button type="submit" class="valdo-btn valdo-btn-primary valdo-btn-lg w-full sm:w-auto"
                        wire:loading.class="loading">
                        <span wire:loading.remove>Kirim Evaluasi Kinerja</span>
                        <span wire:loading>Memproses Data...</span>
                    </button>
                    <p class="text-xs text-gray-500 mt-4 text-center sm:text-right">
                        Dengan menekan tombol kirim, data akan dikunci dan tidak dapat diubah kembali.
                    </p>
                </div>
            </form>

        </div>
    @endif
</div>
