<div>
    {{-- ============================================================
         TOAST NOTIFICATION
    ============================================================ --}}
    @if (session('toast_success'))
        <div class="valdo-toast-container" wire:key="toast-{{ now()->timestamp }}">
            <div class="valdo-toast success" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition>
                <div class="valdo-toast-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </div>
                <div class="valdo-toast-content">
                    <div class="valdo-toast-title">Berhasil</div>
                    <div class="valdo-toast-message">{{ session('toast_success') }}</div>
                </div>
            </div>
        </div>
    @endif

    {{-- ============================================================
         BREADCRUMB / HEADER
    ============================================================ --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.kontrak.index') }}" wire:navigate class="valdo-icon-btn" title="Kembali">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
        </a>
        <div>
            <h1 class="valdo-heading-lg">{{ $karyawan->nama_karyawan }}</h1>
            <p class="valdo-text-muted">{{ $karyawan->posisi }} · NIK <span
                    class="valdo-text-mono">{{ $karyawan->nik }}</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ============================================================
             LEFT: BIODATA KARYAWAN
        ============================================================ --}}
        <div class="lg:col-span-1">
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <h2 class="valdo-heading-md">Biodata Karyawan</h2>
                    <span
                        class="valdo-badge {{ $karyawan->status_karyawan === 'aktif' ? 'valdo-badge-green' : 'valdo-badge-muted' }}">
                        {{ ucfirst($karyawan->status_karyawan) }}
                    </span>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <div class="valdo-text-label mb-1">Nama Lengkap</div>
                        <div style="color:#e2e5f0; font-weight:600; font-size:0.95rem;">{{ $karyawan->nama_karyawan }}
                        </div>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">NIK</div>
                        <div class="valdo-text-mono">{{ $karyawan->nik }}</div>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">Jenis Kelamin</div>
                        <div style="color:#a8adc4; font-size:0.875rem;">{{ $karyawan->jenis_kelamin }}</div>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">Posisi</div>
                        <div style="color:#a8adc4; font-size:0.875rem;">{{ $karyawan->posisi }}</div>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">No. HP</div>
                        <div style="color:#a8adc4; font-size:0.875rem;">{{ $karyawan->no_hp ?? '—' }}</div>
                    </div>
                    <div>
                        <div class="valdo-text-label mb-1">Alamat</div>
                        <div style="color:#a8adc4; font-size:0.875rem; line-height:1.5;">{{ $karyawan->alamat ?? '—' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============================================================
             RIGHT: STATUS KONTRAK + RIWAYAT
        ============================================================ --}}
        <div class="lg:col-span-2 flex flex-col gap-6">

            {{-- === STATUS KONTRAK SAAT INI === --}}
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <h2 class="valdo-heading-md">Status Kontrak Saat Ini</h2>

                    @if ($kontrakAktif)
                        @php
                            [$badgeClass, $badgeLabel] = match (true) {
                                $kontrakAktif->sudahHabis() => ['valdo-badge-red', 'Sudah Habis'],
                                $kontrakAktif->hampirHabis() => ['valdo-badge-pink', 'Hampir Habis'],
                                default => ['valdo-badge-green', 'Aktif'],
                            };
                        @endphp
                        <span class="valdo-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                    @endif
                </div>

                @if ($kontrakAktif)
                    @php $sisa = $kontrakAktif->sisaHari(); @endphp

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">
                        <div>
                            <div class="valdo-text-label mb-1">Jenis</div>
                            <div style="color:#c8ccdc; font-size:0.875rem; font-weight:600;">
                                {{ $kontrakAktif->jenis_kontrak === 'kontrak_awal' ? 'Kontrak Awal' : 'Perpanjangan ke-' . ($kontrakAktif->nomor_urut_kontrak - 1) }}
                            </div>
                        </div>
                        <div>
                            <div class="valdo-text-label mb-1">Mulai</div>
                            <div style="color:#c8ccdc; font-size:0.875rem;">
                                {{ $kontrakAktif->tanggal_mulai->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="valdo-text-label mb-1">Selesai</div>
                            <div style="color:#c8ccdc; font-size:0.875rem;">
                                {{ $kontrakAktif->tanggal_selesai->format('d M Y') }}</div>
                        </div>
                        <div>
                            <div class="valdo-text-label mb-1">Sisa Waktu</div>
                            <div
                                style="font-size:0.875rem; font-weight:600; color: {{ $sisa < 0 ? '#f87171' : ($sisa <= 30 ? '#e879f9' : '#22d3ee') }};">
                                {{ $sisa >= 0 ? $sisa . ' hari' : 'Lewat ' . abs($sisa) . ' hari' }}
                            </div>
                        </div>
                    </div>

                    @if ($kontrakAktif->catatan)
                        <div class="valdo-divider"></div>
                        <div class="mb-5">
                            <div class="valdo-text-label mb-1">Catatan</div>
                            <p style="color:#a8adc4; font-size:0.875rem; white-space:pre-line; line-height:1.6;">
                                {{ $kontrakAktif->catatan }}</p>
                        </div>
                    @endif

                    <div class="flex flex-wrap gap-3">
                        <button type="button" wire:click="bukaModalPerpanjang" class="valdo-btn valdo-btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="1 4 1 10 7 10" />
                                <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
                            </svg>
                            Perpanjang Kontrak
                        </button>
                        <button type="button" wire:click="bukaModalEdit({{ $kontrakAktif->id_kontrak }})"
                            class="valdo-btn valdo-btn-secondary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                            </svg>
                            Edit
                        </button>
                        <button type="button" wire:click="bukaModalPutus" class="valdo-btn valdo-btn-danger">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="15" y1="9" x2="9" y2="15" />
                                <line x1="9" y1="9" x2="15" y2="15" />
                            </svg>
                            Putus Kontrak
                        </button>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center text-center gap-3"
                        style="padding: 32px 16px;">
                        <div
                            style="width:56px; height:56px; border-radius:16px; background:var(--color-base-400); display:flex; align-items:center; justify-content:center; color:#3d4263; box-shadow:var(--neu-shadow-md);">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <polyline points="14 2 14 8 20 8" />
                                <line x1="16" y1="13" x2="8" y2="13" />
                                <line x1="16" y1="17" x2="8" y2="17" />
                            </svg>
                        </div>
                        <p class="valdo-text-muted" style="max-width: 360px;">
                            Karyawan ini belum memiliki kontrak kerja. Buat kontrak awal untuk mulai mencatat masa
                            kerjanya.
                        </p>
                        <button type="button" wire:click="bukaMOdalBuat" class="valdo-btn valdo-btn-primary mt-2">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19" />
                                <line x1="5" y1="12" x2="19" y2="12" />
                            </svg>
                            Buat Kontrak Awal
                        </button>
                    </div>
                @endif
            </div>

            {{-- === RIWAYAT KONTRAK === --}}
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <h2 class="valdo-heading-md">Riwayat Kontrak</h2>
                    <span class="valdo-text-muted" style="font-size:0.75rem;">{{ $riwayatKontrak->count() }}
                        riwayat</span>
                </div>

                @if ($riwayatKontrak->isEmpty())
                    <p class="valdo-text-muted text-center" style="padding: 32px 0;">Belum ada riwayat kontrak.</p>
                @else
                    <div class="flex flex-col gap-3">
                        @foreach ($riwayatKontrak as $riwayat)
                            @php
                                $statusBadgeClass = match ($riwayat->status) {
                                    'aktif' => 'valdo-badge-green',
                                    'selesai' => 'valdo-badge-blue',
                                    'dibatalkan' => 'valdo-badge-red',
                                    default => 'valdo-badge-muted',
                                };
                                $iconColorClass = $riwayat->jenis_kontrak === 'kontrak_awal' ? 'blue' : 'purple';
                            @endphp
                            <div wire:key="riwayat-{{ $riwayat->id_kontrak }}"
                                style="background: var(--color-base-400); border-radius: var(--radius-card); border: 1px solid rgba(255,255,255,0.05); padding: 16px 20px;">
                                <div class="flex items-start justify-between gap-4 flex-wrap">
                                    <div class="flex items-start gap-3">
                                        <div class="valdo-stat-card-icon {{ $iconColorClass }}"
                                            style="width:36px; height:36px; margin-bottom:0; flex-shrink:0;">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                @if ($riwayat->jenis_kontrak === 'kontrak_awal')
                                                    <path
                                                        d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                                    <polyline points="14 2 14 8 20 8" />
                                                @else
                                                    <polyline points="1 4 1 10 7 10" />
                                                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
                                                @endif
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <span style="color:#000; font-weight:600; font-size:0.875rem;">
                                                    {{ $riwayat->jenis_kontrak === 'kontrak_awal' ? 'Kontrak Awal' : 'Perpanjangan ke-' . ($riwayat->nomor_urut_kontrak - 1) }}
                                                </span>
                                                <span
                                                    class="valdo-badge {{ $statusBadgeClass }}">{{ ucfirst($riwayat->status) }}</span>
                                            </div>
                                            <div class="valdo-text-muted" style="font-size:0.75rem; margin-top:4px;">
                                                {{ $riwayat->tanggal_mulai->format('d M Y') }} —
                                                {{ $riwayat->tanggal_selesai->format('d M Y') }}
                                            </div>
                                            @if ($riwayat->catatan)
                                                <p class="valdo-text-muted"
                                                    style="font-size:0.75rem; margin-top:8px; white-space:pre-line; line-height:1.5;">
                                                    {{ $riwayat->catatan }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="button" wire:click="bukaModalEdit({{ $riwayat->id_kontrak }})"
                                        class="valdo-btn valdo-btn-ghost valdo-btn-sm">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ============================================================
         MODAL: BUAT / PERPANJANG / EDIT KONTRAK
    ============================================================ --}}
    <div x-data="{ open: @entangle('showModalKontrak') }" x-show="open" x-cloak class="valdo-modal-backdrop" :class="{ 'open': open }"
        @click.self="$wire.set('showModalKontrak', false)">
        <div class="valdo-modal" @click.stop>
            <div class="valdo-modal-header">
                <h3 class="valdo-heading-md" style="font-size:1.1rem;">
                    @if ($modeModal === 'buat')
                        Buat Kontrak Awal
                    @elseif($modeModal === 'perpanjang')
                        Perpanjang Kontrak
                    @else
                        Edit Kontrak
                    @endif
                </h3>
                <button type="button" wire:click="$set('showModalKontrak', false)" class="valdo-modal-close">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="simpanKontrak">
                <div class="valdo-modal-body">
                    <div class="valdo-input-group">
                        <label class="valdo-label">Tanggal Mulai</label>
                        <input type="date" wire:model="tanggal_mulai"
                            class="valdo-input @error('tanggal_mulai') error @enderror">
                        @error('tanggal_mulai')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="valdo-input-group">
                        <label class="valdo-label">Tanggal Selesai</label>
                        <input type="date" wire:model="tanggal_selesai"
                            class="valdo-input @error('tanggal_selesai') error @enderror">
                        @error('tanggal_selesai')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="valdo-input-group" style="margin-bottom:0;">
                        <label class="valdo-label">Catatan (opsional)</label>
                        <textarea wire:model="catatan" rows="3" class="valdo-textarea"
                            placeholder="Catatan tambahan mengenai kontrak ini..."></textarea>
                        @error('catatan')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="valdo-modal-footer">
                    <button type="button" wire:click="$set('showModalKontrak', false)"
                        class="valdo-btn valdo-btn-ghost">
                        Batal
                    </button>
                    <button type="submit" wire:loading.attr="disabled" wire:target="simpanKontrak"
                        class="valdo-btn valdo-btn-primary">
                        <span wire:loading.remove wire:target="simpanKontrak">Simpan</span>
                        <span wire:loading wire:target="simpanKontrak">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ============================================================
         MODAL: PUTUS KONTRAK
    ============================================================ --}}
    <div x-data="{ open: @entangle('showModalPutus') }" x-show="open" x-cloak class="valdo-modal-backdrop" :class="{ 'open': open }"
        @click.self="$wire.set('showModalPutus', false)">
        <div class="valdo-modal" style="max-width: 460px;" @click.stop>
            <div class="valdo-modal-header">
                <h3 class="valdo-heading-md" style="font-size:1.1rem; color:#f87171;">Putus Kontrak</h3>
                <button type="button" wire:click="$set('showModalPutus', false)" class="valdo-modal-close">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </button>
            </div>

            <div class="valdo-modal-body">
                <p class="valdo-text-muted" style="margin-bottom:16px; line-height:1.6;">
                    Tindakan ini akan menghentikan kontrak aktif karyawan
                    <strong style="color:#c8ccdc;">{{ $karyawan->nama_karyawan }}</strong>
                    sebelum tanggal berakhirnya. Pastikan keputusan ini sudah final.
                </p>
                <div class="valdo-input-group" style="margin-bottom:0;">
                    <label class="valdo-label">Alasan Putus Kontrak</label>
                    <textarea wire:model="alasan_putus" rows="3" class="valdo-textarea"
                        placeholder="Contoh: Kinerja di bawah standar, permintaan klien, dst."></textarea>
                </div>
            </div>

            <div class="valdo-modal-footer">
                <button type="button" wire:click="$set('showModalPutus', false)" class="valdo-btn valdo-btn-ghost">
                    Batal
                </button>
                <button type="button" wire:click="putusKontrak" wire:loading.attr="disabled"
                    wire:target="putusKontrak" class="valdo-btn valdo-btn-danger">
                    <span wire:loading.remove wire:target="putusKontrak">Ya, Putus Kontrak</span>
                    <span wire:loading wire:target="putusKontrak">Memproses...</span>
                </button>
            </div>
        </div>
    </div>
</div>
