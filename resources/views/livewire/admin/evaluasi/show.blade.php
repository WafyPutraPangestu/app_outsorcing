<div>

    <!-- Tombol Kembali -->
    <div class="mb-6">
        <a href="{{ route('admin.evaluasi.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Evaluasi
        </a>
    </div>

    <!-- Header Profil Evaluasi -->
    <div class="valdo-card valdo-card-glow-purple mb-8 overflow-visible relative">
        <div class="absolute top-0 right-0 p-6 opacity-10 pointer-events-none">
            <svg class="w-32 h-32 text-accent-purple" fill="currentColor" viewBox="0 0 24 24">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative z-10">
            <div class="flex items-center gap-5">
                <div
                    class="w-16 h-16 rounded-2xl bg-gradient-to-br from-accent-purple to-accent-pink p-0.5 shadow-neu-lg valdo-float">
                    <div
                        class="w-full h-full bg-base-300 rounded-2xl flex items-center justify-center text-2xl font-bold text-white">
                        {{ substr($evaluasi->penempatan->karyawan->nama_karyawan, 0, 1) }}
                    </div>
                </div>
                <div>
                    <h1 class="valdo-heading-lg">{{ $evaluasi->penempatan->karyawan->nama_karyawan }}</h1>
                    <p class="text-accent-cyan font-medium flex items-center gap-2 mt-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $evaluasi->penempatan->klien->nama_perusahaan }}
                    </p>
                </div>
            </div>

            <div class="text-left md:text-right">
                <div class="valdo-text-label mb-1">Periode Evaluasi</div>
                <div class="text-2xl font-bold text-white tracking-widest">{{ $evaluasi->periode }}</div>
            </div>
        </div>
    </div>

    <!-- Flash Messages Khusus Verifikasi -->
    @if (session()->has('message'))
        <div class="valdo-card bg-emerald-500/10 border-emerald-500/30 mb-8 p-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-emerald-400 font-medium">{{ session('message') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="valdo-card bg-red-500/10 border-red-500/30 mb-8 p-4 flex items-center gap-3">
            <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-red-400 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Layout Grid Utama -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- Kolom Kiri: Rincian Nilai -->
        <div class="lg:col-span-2 space-y-8">

            <!-- Card Skor Total -->
            <div class="valdo-stat-card flex items-center justify-between border-l-4 border-l-accent-blue">
                <div>
                    <h3 class="valdo-text-label">Skor Akhir Evaluasi</h3>
                    <div class="text-5xl font-black text-white mt-2">{{ $evaluasi->total_nilai_akhir ?? '0.00' }}</div>
                </div>
                <div class="w-20 h-20 rounded-full border-4 border-accent-blue/20 flex items-center justify-center">
                    <span class="text-accent-blue font-bold text-xl">100</span>
                </div>
            </div>

            <!-- Card Rincian Kriteria -->
            <div class="valdo-card">
                <h3 class="valdo-heading-md mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    Rincian Penilaian Klien
                </h3>

                @if ($evaluasi->detail->isEmpty())
                    <div class="text-center py-8 text-gray-500 bg-base-200 rounded-xl border border-white/5">
                        Klien belum mengisi rincian evaluasi ini.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach ($evaluasi->detail as $dtl)
                            <div class="p-4 bg-base-200 rounded-xl border border-white/5 relative overflow-hidden">
                                <!-- Progress Bar Background -->
                                <div class="absolute top-0 left-0 h-full bg-accent-blue/5 transition-all duration-1000"
                                    style="width: {{ $dtl->skor_nilai }}%;"></div>

                                <div class="relative z-10 flex justify-between items-center">
                                    <div>
                                        <h4 class="font-bold text-white">{{ $dtl->kriteria->nama_kriteria }}</h4>
                                        <p class="text-xs text-gray-500 mt-1">Bobot:
                                            {{ (int) $dtl->kriteria->bobot_nilai }}%</p>
                                    </div>
                                    <div
                                        class="text-2xl font-black {{ $dtl->skor_nilai >= 70 ? 'text-emerald-400' : ($dtl->skor_nilai >= 50 ? 'text-yellow-400' : 'text-red-400') }}">
                                        {{ $dtl->skor_nilai }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Komentar Klien -->
                <div class="mt-8 pt-6 border-t border-white/5">
                    <h4 class="valdo-text-label mb-3">Catatan / Feedback dari Klien</h4>
                    <div class="p-5 bg-base-200 rounded-xl border border-white/5 text-gray-300 italic shadow-neu-inset">
                        "{{ $evaluasi->komentar_klien ?? 'Tidak ada komentar khusus dari klien.' }}"
                    </div>
                    <p class="text-xs text-gray-500 mt-2 text-right">Diisi pada:
                        {{ $evaluasi->tanggal_diisi_klien ? $evaluasi->tanggal_diisi_klien->format('d M Y') : '-' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Panel Verifikasi -->
        <div class="lg:col-span-1">
            <div class="valdo-card sticky top-24">
                <h3 class="valdo-heading-md mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    Panel Verifikasi
                </h3>

                <!-- Status Badge Besar -->
                <div
                    class="mb-6 p-4 rounded-xl text-center font-bold text-sm tracking-wide uppercase border shadow-neu-inset
                    @if ($evaluasi->status_evaluasi == 'menunggu_klien') bg-gray-500/10 text-gray-400 border-gray-500/30
                    @elseif($evaluasi->status_evaluasi == 'menunggu_verifikasi') bg-cyan-500/10 text-cyan-400 border-cyan-500/30
                    @elseif($evaluasi->status_evaluasi == 'verified') bg-emerald-500/10 text-emerald-400 border-emerald-500/30
                    @else bg-red-500/10 text-red-400 border-red-500/30 @endif
                ">
                    Status: {{ str_replace('_', ' ', $evaluasi->status_evaluasi) }}
                </div>

                <!-- Form Verifikasi (Hanya muncul jika status menunggu_verifikasi) -->
                @if ($evaluasi->status_evaluasi === 'menunggu_verifikasi')
                    <form>
                        <div class="valdo-input-group mb-6">
                            <label class="valdo-label text-white mb-2">Catatan Verifikator (Opsional/Wajib jika
                                ditolak)</label>
                            <textarea wire:model="catatan_verifikator" class="valdo-textarea" placeholder="Tambahkan catatan internal..."></textarea>
                            @error('catatan_verifikator')
                                <span class="valdo-input-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex flex-col gap-3 mt-4 pt-6 border-t border-white/5">
                            <button type="button" wire:click="verifikasi" wire:confirm="Sahkah data evaluasi ini?"
                                class="valdo-btn valdo-btn-primary w-full justify-center" wire:loading.attr="disabled">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                Sahkan & Verifikasi
                            </button>
                            <button type="button" wire:click="tolak"
                                wire:confirm="Tolak data ini? Klien mungkin harus mengisi ulang."
                                class="valdo-btn valdo-btn-danger w-full justify-center" wire:loading.attr="disabled">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak Data
                            </button>
                        </div>
                    </form>
                @else
                    <!-- Info jika sudah diproses -->
                    <div class="valdo-input-group mb-4">
                        <label class="valdo-label text-gray-500 mb-1">Catatan Verifikator</label>
                        <div class="p-4 bg-base-200 rounded-xl border border-white/5 text-gray-300">
                            {{ $evaluasi->catatan_verifikator ?? 'Tidak ada catatan.' }}
                        </div>
                    </div>

                    @if ($evaluasi->verifikator)
                        <div class="flex items-center gap-3 mt-6 pt-4 border-t border-white/5">
                            <div
                                class="w-10 h-10 rounded-full bg-base-400 flex items-center justify-center font-bold text-accent-blue">
                                {{ substr($evaluasi->verifikator->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Diverifikasi Oleh:</p>
                                <p class="text-sm font-bold text-white">{{ $evaluasi->verifikator->name }}</p>
                                <p class="text-xs text-accent-cyan">
                                    {{ $evaluasi->verified_at ? $evaluasi->verified_at->format('d M Y H:i') : '' }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>

    </div>
</div>
