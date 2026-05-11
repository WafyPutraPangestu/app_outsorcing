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

    <!-- Banner Profil Klien -->
    <div class="valdo-card valdo-card-glow-blue mb-8 relative overflow-hidden">
        <!-- Dekorasi Background -->
        <div class="absolute -top-10 -right-10 w-64 h-64 bg-accent-blue/10 rounded-full blur-3xl pointer-events-none">
        </div>

        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10">
            <!-- Avatar Logo Perusahaan -->
            <div
                class="w-20 h-20 rounded-2xl bg-gradient-to-br from-accent-blue to-accent-indigo p-0.5 shadow-neu-lg valdo-float">
                <div
                    class="w-full h-full bg-base-300 rounded-2xl flex items-center justify-center text-3xl font-black text-white">
                    {{ substr($klien->nama_perusahaan, 0, 1) }}
                </div>
            </div>

            <div class="flex-1">
                <h1 class="valdo-heading-xl text-3xl mb-1">{{ $klien->nama_perusahaan }}</h1>
                <div class="flex flex-wrap gap-4 mt-3">
                    <span class="flex items-center text-sm text-gray-400">
                        <svg class="w-4 h-4 mr-1.5 text-accent-cyan" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ $klien->email_hrd_klien }}
                    </span>
                    <span class="flex items-center text-sm text-gray-400">
                        <svg class="w-4 h-4 mr-1.5 text-accent-purple" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        PIC: {{ $klien->nama_kontak_person ?? 'Belum diatur' }}
                    </span>
                </div>
            </div>

            <div>
                <a href="{{ route('admin.klien.edit', $klien->id_klien) }}" wire:navigate
                    class="valdo-btn valdo-btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                        </path>
                    </svg>
                    Edit Profil
                </a>
            </div>
        </div>

        @if ($klien->alamat_kantor)
            <div class="mt-6 pt-5 border-t border-white/5 relative z-10">
                <h3 class="valdo-text-label mb-2">Alamat Kantor</h3>
                <p class="text-gray-300 text-sm leading-relaxed max-w-3xl">{{ $klien->alamat_kantor }}</p>
            </div>
        @endif
    </div>

    <!-- Bagian Daftar Karyawan (Ditarik dari relasi Penempatan) -->
    <h2 class="valdo-heading-md mb-4 flex items-center gap-2">
        <svg class="w-5 h-5 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
            </path>
        </svg>
        Karyawan di Perusahaan Ini
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($klien->penempatan as $p)
            <div class="valdo-card group hover:border-accent-blue/30 transition-colors">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-base-200 border border-white/5 shadow-neu-inset flex items-center justify-center text-gray-400 font-bold group-hover:text-accent-blue transition-colors">
                            {{ substr($p->karyawan->nama_karyawan, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-white leading-tight">{{ $p->karyawan->nama_karyawan }}</h3>
                            <p class="text-xs text-accent-cyan">{{ $p->karyawan->posisi }}</p>
                        </div>
                    </div>
                    @if ($p->status_aktif)
                        <span class="valdo-badge valdo-badge-green">Aktif</span>
                    @else
                        <span class="valdo-badge valdo-badge-muted">Nonaktif</span>
                    @endif
                </div>

                <div class="text-xs text-gray-500 bg-base-200 p-3 rounded-lg border border-white/5">
                    <div class="flex justify-between mb-1">
                        <span>Mulai:</span>
                        <span class="text-gray-300">{{ $p->tanggal_mulai->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Selesai:</span>
                        <span
                            class="text-gray-300">{{ $p->tanggal_selesai ? $p->tanggal_selesai->format('d M Y') : 'Kontrak Berjalan' }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full valdo-card text-center py-10 border-dashed border-gray-600">
                <p class="text-gray-500">Belum ada karyawan yang ditempatkan di klien ini.</p>
            </div>
        @endforelse
    </div>

</div>
