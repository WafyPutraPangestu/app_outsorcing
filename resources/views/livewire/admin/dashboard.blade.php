<div>

    <!-- Ucapan Selamat Datang -->
    <div class="mb-8 flex flex-col md:flex-row justify-between md:items-end gap-4">
        <div>
            <h1 class="valdo-heading-xl text-3xl mb-1">Selamat Datang, {{ auth()->user()->name }}!</h1>
            <p class="valdo-text-muted">Berikut adalah ringkasan operasional PT Valdo hari ini.</p>
        </div>
        <div class="text-right hidden md:block">
            <div class="text-sm font-bold text-accent-blue">{{ now()->format('l, d F Y') }}</div>
        </div>
    </div>

    <!-- 4 Kartu Statistik (Stat Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Stat: Karyawan -->
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon blue">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $stats['karyawan_aktif'] }}</div>
            <div class="valdo-stat-label">Karyawan Aktif</div>
        </div>

        <!-- Stat: Klien -->
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon purple">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $stats['total_klien'] }}</div>
            <div class="valdo-stat-label">Mitra Klien</div>
        </div>

        <!-- Stat: Penempatan -->
        <div class="valdo-stat-card">
            <div class="valdo-stat-card-icon cyan">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $stats['kontrak_aktif'] }}</div>
            <div class="valdo-stat-label">Kontrak Aktif</div>
        </div>

        <!-- Stat: Perlu Verifikasi -->
        <div
            class="valdo-stat-card border-t-4 {{ $stats['perlu_verifikasi'] > 0 ? 'border-t-accent-pink' : 'border-t-transparent' }}">
            <div class="valdo-stat-card-icon pink {{ $stats['perlu_verifikasi'] > 0 ? 'animate-pulse' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
            </div>
            <div class="valdo-stat-value">{{ $stats['perlu_verifikasi'] }}</div>
            <div class="valdo-stat-label">Menunggu Verifikasi</div>
        </div>

    </div>

    <!-- Layout Grid: Kiri (Evaluasi) & Kanan (Peringatan Kontrak) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- Panel Kiri: Aktivitas Evaluasi Terbaru -->
        <div class="valdo-card">
            <div class="flex justify-between items-center mb-6">
                <h3 class="valdo-heading-md flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                        </path>
                    </svg>
                    Evaluasi Terbaru
                </h3>
                <a href="{{ route('admin.evaluasi.index') }}" wire:navigate
                    class="text-xs text-accent-cyan hover:underline">Lihat Semua</a>
            </div>

            <div class="space-y-4">
                @forelse($evaluasiTerbaru as $eval)
                    <div
                        class="p-4 bg-base-200 rounded-xl border border-white/5 shadow-neu-inset flex justify-between items-center group hover:border-accent-blue/30 transition-colors">
                        <div>
                            <div class="font-bold text-white text-sm">{{ $eval->penempatan->karyawan->nama_karyawan }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $eval->penempatan->klien->nama_perusahaan }} •
                                <span class="text-accent-purple">{{ $eval->periode }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            @if ($eval->status_evaluasi == 'menunggu_klien')
                                <span class="valdo-badge valdo-badge-muted text-[10px]">Menunggu Klien</span>
                            @elseif($eval->status_evaluasi == 'menunggu_verifikasi')
                                <a href="{{ route('admin.evaluasi.show', $eval->id_evaluasi) }}" wire:navigate
                                    class="valdo-badge valdo-badge-pink text-[10px] cursor-pointer hover:bg-pink-500/30">Cek
                                    Sekarang</a>
                            @elseif($eval->status_evaluasi == 'verified')
                                <span class="valdo-badge valdo-badge-green text-[10px]">Verified:
                                    {{ $eval->total_nilai_akhir }}</span>
                            @else
                                <span class="valdo-badge valdo-badge-red text-[10px]">Ditolak</span>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 text-gray-500 text-sm italic">
                        Belum ada aktivitas evaluasi.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Panel Kanan: Peringatan Kontrak Habis -->
        <div class="valdo-card valdo-card-glow-purple border-t-4 border-t-accent-pink">
            <div class="flex justify-between items-center mb-6">
                <h3 class="valdo-heading-md flex items-center gap-2">
                    <svg class="w-5 h-5 text-accent-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Kontrak Segera Berakhir (< 30 Hari) </h3>
            </div>

            <div class="space-y-4">
                @forelse($kontrakHampirHabis as $kontrak)
                    @php
                        $sisaHari = now()->diffInDays($kontrak->tanggal_selesai, false);
                    @endphp
                    <div
                        class="p-4 bg-base-200 rounded-xl border border-white/5 shadow-neu-inset flex justify-between items-center relative overflow-hidden">
                        <!-- Indikator Kritis -->
                        @if ($sisaHari <= 7)
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-red-500"></div>
                        @else
                            <div class="absolute left-0 top-0 bottom-0 w-1 bg-yellow-500"></div>
                        @endif

                        <div class="pl-2">
                            <div class="font-bold text-white text-sm">{{ $kontrak->karyawan->nama_karyawan }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ $kontrak->klien->nama_perusahaan }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs font-bold {{ $sisaHari <= 7 ? 'text-red-400' : 'text-yellow-400' }}">
                                Sisa {{ ceil($sisaHari) }} Hari
                            </div>
                            <div class="text-[10px] text-gray-500 mt-1">
                                {{ $kontrak->tanggal_selesai->format('d M Y') }}</div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-6 flex flex-col items-center justify-center text-gray-500">
                        <div
                            class="w-12 h-12 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-400 mb-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-sm">Aman! Tidak ada kontrak yang akan habis dalam waktu dekat.</p>
                    </div>
                @endforelse
            </div>

            @if (count($kontrakHampirHabis) > 0)
                <div class="mt-6 pt-4 border-t border-white/5 text-center">
                    <p class="text-xs text-gray-400">Pastikan proses evaluasi selesai sebelum kontrak berakhir untuk
                        menentukan status perpanjangan.</p>
                </div>
            @endif
        </div>

    </div>
</div>
