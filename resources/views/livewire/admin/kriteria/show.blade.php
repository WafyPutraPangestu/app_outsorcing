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

    <div class="max-w-3xl mx-auto">
        <div class="valdo-card valdo-card-glow-blue relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div
                class="absolute -top-20 -right-20 w-64 h-64 bg-accent-blue/5 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="flex flex-col md:flex-row justify-between items-start gap-6 relative z-10">
                <div class="flex items-start gap-5">
                    <div
                        class="w-16 h-16 rounded-2xl bg-base-200 border border-white/5 shadow-neu-inset flex items-center justify-center text-accent-blue valdo-float">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">Nama Kriteria</div>
                        <h1 class="valdo-heading-lg text-2xl">{{ $kriteria->nama_kriteria }}</h1>
                        <p class="text-xs text-gray-500 mt-2 font-mono">ID Kriteria: #{{ $kriteria->id_kriteria }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <a href="{{ route('admin.kriteria.edit', $kriteria->id_kriteria) }}" wire:navigate
                        class="valdo-btn valdo-btn-secondary valdo-btn-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                        Edit Data
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-10 relative z-10">
                <div class="bg-base-200 p-5 rounded-xl border border-white/5 shadow-neu-inset">
                    <h3 class="valdo-text-label mb-2">Bobot Nilai</h3>
                    <div class="text-4xl font-black text-white">
                        {{ (float) $kriteria->bobot_nilai }}<span class="text-lg text-gray-500">%</span>
                    </div>
                </div>

                <div class="bg-base-200 p-5 rounded-xl border border-white/5 shadow-neu-inset">
                    <h3 class="valdo-text-label mb-2">Status Saat Ini</h3>
                    <div class="mt-2">
                        @if ($kriteria->is_aktif)
                            <span class="valdo-badge valdo-badge-blue text-sm px-4 py-2"><span
                                    class="w-2 h-2 rounded-full bg-accent-blue mr-2 animate-pulse"></span> Sedang
                                Aktif</span>
                        @else
                            <span class="valdo-badge valdo-badge-muted text-sm px-4 py-2">Tidak Aktif</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-white/5 flex justify-between items-center text-xs text-gray-500">
                <span>Dibuat: {{ $kriteria->created_at->format('d M Y, H:i') }}</span>
                <span>Terakhir diperbarui: {{ $kriteria->updated_at->format('d M Y, H:i') }}</span>
            </div>
        </div>
    </div>
</div>
