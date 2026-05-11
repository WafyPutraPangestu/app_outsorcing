<div>

    {{-- ── BREADCRUMB ── --}}
    <div class="flex items-center gap-2 mb-6" style="color:#3d4263; font-size:0.8rem;">
        <a href="{{ route('admin.karyawan.index') }}" wire:navigate class="hover:text-accent-blue transition-colors"
            style="color:#6b7190;">Karyawan</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6" />
        </svg>
        <span style="color:#4f8ef7;">Tambah Baru</span>
    </div>

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="valdo-heading-lg">Tambah Karyawan Baru</h1>
            <p class="valdo-text-muted mt-1">Isi biodata lengkap karyawan untuk didaftarkan ke sistem</p>
        </div>
        <a href="{{ route('admin.karyawan.index') }}" wire:navigate class="valdo-btn valdo-btn-ghost valdo-btn-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12" />
                <polyline points="12 19 5 12 12 5" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── FORM CARD ── --}}
        <div class="lg:col-span-2">
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <div class="flex items-center gap-3">
                        <div class="valdo-stat-card-icon blue"
                            style="width:36px;height:36px;border-radius:10px;margin-bottom:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                        </div>
                        <span class="valdo-heading-md">Data Pribadi</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5">

                    {{-- NIK --}}
                    <div class="valdo-input-group sm:col-span-2">
                        <label class="valdo-label">NIK <span style="color:#ef4444;">*</span></label>
                        <div class="valdo-input-wrapper">
                            <span class="valdo-input-prefix">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="16" rx="2" />
                                    <line x1="7" y1="9" x2="17" y2="9" />
                                    <line x1="7" y1="13" x2="11" y2="13" />
                                </svg>
                            </span>
                            <input wire:model.blur="nik" type="text"
                                class="valdo-input @error('nik') error @enderror" placeholder="Contoh: KRY-2024-001"
                                maxlength="50">
                        </div>
                        @error('nik')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="valdo-input-group sm:col-span-2">
                        <label class="valdo-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                        <input wire:model.blur="nama_karyawan" type="text"
                            class="valdo-input @error('nama_karyawan') error @enderror" placeholder="Nama sesuai KTP">
                        @error('nama_karyawan')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                        <div class="flex gap-3 mt-1">
                            @foreach (['Laki-laki', 'Perempuan'] as $jk)
                                <label x-data
                                    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl border transition-all duration-200"
                                    :class="$wire.jenis_kelamin === '{{ $jk }}' ?
                                        'border-blue-500/40 bg-blue-500/10' : 'border-white/6 bg-base-200'"
                                    style="flex:1; justify-content:center;">
                                    <input type="radio" wire:model.live="jenis_kelamin" value="{{ $jk }}"
                                        class="hidden">
                                    <span style="font-size:0.875rem; font-weight:500;"
                                        :style="$wire.jenis_kelamin === '{{ $jk }}' ? 'color:#4f8ef7' :
                                            'color:#6b7190'">
                                        {{ $jk === 'Laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Posisi --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label">Posisi / Jabatan <span style="color:#ef4444;">*</span></label>
                        <input wire:model.blur="posisi" type="text"
                            class="valdo-input @error('posisi') error @enderror"
                            placeholder="Contoh: Security, Operator">
                        @error('posisi')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- No HP --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label">No. Handphone</label>
                        <div class="valdo-input-wrapper">
                            <span class="valdo-input-prefix">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.32 2 2 0 0 1 3.6 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.6a16 16 0 0 0 5.55 5.55l.96-.96a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z" />
                                </svg>
                            </span>
                            <input wire:model.blur="no_hp" type="text"
                                class="valdo-input @error('no_hp') error @enderror" placeholder="08xxxxxxxxxx">
                        </div>
                        @error('no_hp')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="valdo-input-group sm:col-span-2">
                        <label class="valdo-label">Alamat Lengkap</label>
                        <textarea wire:model.blur="alamat" class="valdo-textarea @error('alamat') error @enderror"
                            placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota..." rows="3"></textarea>
                        @error('alamat')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- ── ACTIONS ── --}}
                <div class="valdo-divider"></div>
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.karyawan.index') }}" wire:navigate
                        class="valdo-btn valdo-btn-secondary">
                        Batal
                    </a>
                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                        class="valdo-btn valdo-btn-primary">
                        <span wire:loading.remove wire:target="save">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round"
                                style="display:inline;vertical-align:middle;margin-right:6px;">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                <polyline points="17 21 17 13 7 13 7 21" />
                                <polyline points="7 3 7 8 15 8" />
                            </svg>
                            Simpan Karyawan
                        </span>
                        <span wire:loading wire:target="save" class="flex items-center gap-2">
                            <svg class="animate-spin" xmlns="http://www.w3.org/2000/svg" width="14"
                                height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </div>
        </div>

        {{-- ── SIDEBAR INFO ── --}}
        <div class="flex flex-col gap-4">

            {{-- Tips Card --}}
            <div class="valdo-card valdo-card-glow-blue">
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="var(--color-accent-blue)" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    <span class="valdo-text-label" style="color:var(--color-accent-blue);">Panduan
                        Pengisian</span>
                </div>
                <ul style="color:#6b7190; font-size:0.8125rem; line-height:1.7; list-style:none; padding:0; margin:0;">
                    <li style="display:flex;align-items:flex-start;gap:8px;margin-bottom:8px;">
                        <span style="color:var(--color-accent-blue);margin-top:2px;">•</span>
                        <span>NIK harus unik dan tidak boleh sama dengan karyawan lain</span>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:8px;margin-bottom:8px;">
                        <span style="color:var(--color-accent-blue);margin-top:2px;">•</span>
                        <span>Kolom bertanda <strong style="color:#ef4444;">*</strong> wajib diisi</span>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:8px;margin-bottom:8px;">
                        <span style="color:var(--color-accent-blue);margin-top:2px;">•</span>
                        <span>No. HP format 10–15 digit angka</span>
                    </li>
                    <li style="display:flex;align-items:flex-start;gap:8px;">
                        <span style="color:var(--color-accent-blue);margin-top:2px;">•</span>
                        <span>Status karyawan default: <strong style="color:#34d399;">Aktif</strong></span>
                    </li>
                </ul>
            </div>

            {{-- Log Info --}}
            <div class="valdo-card">
                <div class="flex items-center gap-2 mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                        fill="none" stroke="#6b7190" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                    <span class="valdo-text-label">Log Keamanan</span>
                </div>
                <p style="color:#6b7190; font-size:0.8rem; line-height:1.6;">
                    Setiap penambahan karyawan akan tercatat secara otomatis di <strong style="color:#8892b0;">Log
                        Aktivitas</strong> beserta identitas admin dan waktu kejadian.
                </p>
            </div>

        </div>
    </div>

</div>
