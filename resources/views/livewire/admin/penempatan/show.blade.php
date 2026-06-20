<div>

    <div class="mb-6">
        <a href="{{ route('admin.penempatan.index') }}" wire:navigate
            class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-black transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Penempatan
        </a>
    </div>

    <!-- Profil Singkat Relasi -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- Card Info Karyawan -->
        <div class="valdo-card valdo-card-glow-blue relative overflow-hidden">
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-accent-blue/10 rounded-full blur-2xl pointer-events-none">
            </div>
            <h3 class="valdo-text-label mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Data Karyawan
            </h3>
            <div class="flex items-center gap-4 relative z-10">
                <div
                    class="w-14 h-14 rounded-full bg-base-200 border border-white/5 flex items-center justify-center font-bold text-xl text-black shadow-neu-inset">
                    {{ substr($penempatan->karyawan->nama_karyawan, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-black">{{ $penempatan->karyawan->nama_karyawan }}</h2>
                    <p class="text-sm text-gray-400">NIK: {{ $penempatan->karyawan->nik }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/5 flex justify-end">
                <a href="{{ route('admin.karyawan.show', $penempatan->id_karyawan) }}" wire:navigate
                    class="text-xs font-semibold text-accent-cyan hover:underline">Lihat Profil Lengkap &rarr;</a>
            </div>
        </div>

        <!-- Card Info Klien -->
        <div class="valdo-card valdo-card-glow-purple relative overflow-hidden">
            <div
                class="absolute -top-10 -right-10 w-32 h-32 bg-accent-purple/10 rounded-full blur-2xl pointer-events-none">
            </div>
            <h3 class="valdo-text-label mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-accent-purple" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                Ditempatkan Di
            </h3>
            <div class="flex items-center gap-4 relative z-10">
                <div
                    class="w-14 h-14 rounded-full bg-base-200 border border-white/5 flex items-center justify-center font-bold text-xl text-black shadow-neu-inset">
                    {{ substr($penempatan->klien->nama_perusahaan, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-black">{{ $penempatan->klien->nama_perusahaan }}</h2>
                    <p class="text-sm text-gray-400">Kontak: {{ $penempatan->klien->nama_kontak_person ?? '-' }}</p>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-white/5 flex justify-end">
                <a href="{{ route('admin.klien.show', $penempatan->id_klien) }}" wire:navigate
                    class="text-xs font-semibold text-accent-purple hover:underline">Lihat Detail Klien &rarr;</a>
            </div>
        </div>

    </div>

    <!-- Detail Kontrak -->
    <div class="valdo-card mb-8">
        <div class="flex justify-between items-center mb-6">
            <h3 class="valdo-heading-md">Informasi Kontrak Kerja</h3>
            @if ($penempatan->status_aktif)
                <span class="valdo-badge valdo-badge-green px-3 py-1 text-sm"><span
                        class="w-2 h-2 rounded-full bg-emerald-400 mr-2 animate-pulse"></span> Sedang Aktif</span>
            @else
                <span class="valdo-badge valdo-badge-muted px-3 py-1 text-sm">Nonaktif / Selesai</span>
            @endif
        </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-base-200 rounded-xl border border-white/5 shadow-neu-inset">
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Mulai</div>
                <div class="text-lg text-black font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ $penempatan->tanggal_mulai->format('d F Y') }}
                </div>
            </div>
            <div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Selesai</div>
                <div class="text-lg text-black font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 {{ $penempatan->tanggal_selesai ? 'text-accent-pink' : 'text-gray-500' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    {{ $penempatan->tanggal_selesai ? $penempatan->tanggal_selesai->format('d F Y') : 'Berjalan tanpa batas' }}
                </div>
            </div>
        </div>

        <!-- Prediksi Sistem berdasarkan Status -->
        <div class="mt-6">
            <h4 class="valdo-text-label mb-2">Rekomendasi Sistem (Berdasarkan Evaluasi Terakhir)</h4>
            @if ($penempatan->rekomendasi_sistem == 'lanjut_kontrak')
                <div
                    class="p-4 rounded-xl border border-emerald-500/30 bg-emerald-500/10 text-emerald-400 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Direkomendasikan untuk Lanjut Kontrak
                </div>
            @elseif($penempatan->rekomendasi_sistem == 'putus_kontrak')
                <div
                    class="p-4 rounded-xl border border-red-500/30 bg-red-500/10 text-red-400 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    Direkomendasikan untuk Putus Kontrak (Di bawah standar)
                </div>
            @else
                <div
                    class="p-4 rounded-xl border border-gray-500/30 bg-gray-500/10 text-gray-400 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Belum ada data evaluasi yang memadai untuk memberikan rekomendasi.
                </div>
            @endif
        </div>
    </div>

</div>
