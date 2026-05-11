<div>

    {{-- ── BREADCRUMB ── --}}
    <div class="flex items-center gap-2 mb-6" style="color:#3d4263; font-size:0.8rem;">
        <a href="{{ route('admin.karyawan.index') }}" wire:navigate class="hover:text-accent-blue transition-colors"
            style="color:#6b7190;">Karyawan</a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6" />
        </svg>
        <a href="{{ route('admin.karyawan.show', $karyawan->id_karyawan) }}" wire:navigate style="color:#6b7190;"
            class="hover:text-accent-blue transition-colors">
            {{ $karyawan->nama_karyawan }}
        </a>
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="9 18 15 12 9 6" />
        </svg>
        <span style="color:#4f8ef7;">Edit</span>
    </div>

    {{-- ── PAGE HEADER ── --}}
    <div class="flex items-start justify-between mb-8">
        <div>
            <h1 class="valdo-heading-lg">Edit Data Karyawan</h1>
            <p class="valdo-text-muted mt-1">
                Memperbarui data untuk
                <span style="color:#c8ccdc; font-weight:600;">{{ $karyawan->nama_karyawan }}</span>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.karyawan.show', $karyawan->id_karyawan) }}" wire:navigate
                class="valdo-btn valdo-btn-ghost valdo-btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- ── MAIN FORM ── --}}
        <div class="lg:col-span-2">
            <div class="valdo-card">
                <div class="valdo-card-header">
                    <div class="flex items-center gap-3">
                        <div class="valdo-table-avatar"
                            style="width:40px;height:40px;font-size:0.875rem;border-radius:12px;">
                            {{ strtoupper(substr($karyawan->nama_karyawan, 0, 2)) }}
                        </div>
                        <div>
                            <p class="valdo-heading-md" style="font-size:1rem;">{{ $karyawan->nama_karyawan }}</p>
                            <p class="valdo-text-mono">{{ $karyawan->nik }}</p>
                        </div>
                    </div>
                    {{-- Status Badge --}}
                    @if ($karyawan->status_karyawan === 'aktif')
                        <span class="valdo-badge valdo-badge-green">Aktif</span>
                    @else
                        <span class="valdo-badge valdo-badge-muted">Nonaktif</span>
                    @endif
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
                                class="valdo-input @error('nik') error @enderror" maxlength="50">
                        </div>
                        @error('nik')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="valdo-input-group sm:col-span-2">
                        <label class="valdo-label">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                        <input wire:model.blur="nama_karyawan" type="text"
                            class="valdo-input @error('nama_karyawan') error @enderror">
                        @error('nama_karyawan')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label">Jenis Kelamin <span style="color:#ef4444;">*</span></label>
                        <div class="flex gap-3 mt-1">
                            @foreach (['Laki-laki', 'Perempuan'] as $jk)
                                <label
                                    class="flex items-center gap-2 cursor-pointer px-4 py-2 rounded-xl border transition-all duration-200"
                                    style="flex:1; justify-content:center;
                                                  {{ $jenis_kelamin === $jk ? 'border-color:rgba(79,142,247,0.4);background:rgba(79,142,247,0.1);' : 'border-color:rgba(255,255,255,0.06);background:var(--color-base-200);' }}">
                                    <input type="radio" wire:model.live="jenis_kelamin"
                                        value="{{ $jk }}" class="hidden">
                                    <span
                                        style="font-size:0.875rem; font-weight:500;
                                                     color: {{ $jenis_kelamin === $jk ? '#4f8ef7' : '#6b7190' }};">
                                        {{ $jk === 'Laki-laki' ? '♂ Laki-laki' : '♀ Perempuan' }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Status Karyawan --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label">Status Karyawan <span style="color:#ef4444;">*</span></label>
                        <div class="valdo-select-wrapper">
                            <select wire:model.live="status_karyawan"
                                class="valdo-select @error('status_karyawan') error @enderror">
                                <option value="aktif">✓ Aktif</option>
                                <option value="nonaktif">✕ Nonaktif</option>
                            </select>
                        </div>
                        @error('status_karyawan')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Posisi --}}
                    <div class="valdo-input-group sm:col-span-2">
                        <label class="valdo-label">Posisi / Jabatan <span style="color:#ef4444;">*</span></label>
                        <input wire:model.blur="posisi" type="text"
                            class="valdo-input @error('posisi') error @enderror">
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
                        <textarea wire:model.blur="alamat" class="valdo-textarea @error('alamat') error @enderror" rows="3"></textarea>
                        @error('alamat')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- ── ACTIONS ── --}}
                <div class="valdo-divider"></div>
                <div class="flex items-center justify-between">
                    <p class="valdo-text-muted" style="font-size:0.75rem;">
                        Terakhir diperbarui: {{ $karyawan->updated_at->diffForHumans() }}
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.karyawan.show', $karyawan->id_karyawan) }}" wire:navigate
                            class="valdo-btn valdo-btn-secondary">
                            Batal
                        </a>
                        <button wire:click="update" wire:loading.attr="disabled" wire:target="update"
                            class="valdo-btn valdo-btn-primary">
                            <span wire:loading.remove wire:target="update">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    style="display:inline;vertical-align:middle;margin-right:6px;">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                                Simpan Perubahan
                            </span>
                            <span wire:loading wire:target="update" class="flex items-center gap-2">
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
        </div>

        {{-- ── SIDEBAR ── --}}
        <div class="flex flex-col gap-4">

            {{-- Danger Zone --}}
            <div class="valdo-card" style="border-color: rgba(239,68,68,0.15);">
                <div class="flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                        fill="none" stroke="#ef4444" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path
                            d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                        <line x1="12" y1="9" x2="12" y2="13" />
                        <line x1="12" y1="17" x2="12.01" y2="17" />
                    </svg>
                    <span class="valdo-text-label" style="color:#ef4444;">Danger Zone</span>
                </div>
                <p style="color:#6b7190; font-size:0.8rem; line-height:1.6; margin-bottom:16px;">
                    Menonaktifkan atau menghapus karyawan akan berdampak pada data penempatan yang terkait.
                </p>
                @if ($status_karyawan === 'aktif')
                    <button wire:click="$set('status_karyawan', 'nonaktif')" class="valdo-btn valdo-btn-sm w-full"
                        style="width:100%;background:rgba(239,68,68,0.1);color:#f87171;border:1px solid rgba(239,68,68,0.2);">
                        Nonaktifkan Karyawan
                    </button>
                @else
                    <button wire:click="$set('status_karyawan', 'aktif')" class="valdo-btn valdo-btn-sm w-full"
                        style="width:100%;background:rgba(52,211,153,0.1);color:#34d399;border:1px solid rgba(52,211,153,0.2);">
                        Aktifkan Kembali
                    </button>
                @endif
            </div>

            {{-- Info Timestamp --}}
            <div class="valdo-card">
                <p class="valdo-text-label mb-3">Informasi Record</p>
                <div style="display:flex;flex-direction:column;gap:12px;">
                    <div>
                        <p class="valdo-text-muted" style="font-size:0.7rem;margin-bottom:2px;">Dibuat pada</p>
                        <p style="color:#c8ccdc; font-size:0.8125rem; font-weight:500;">
                            {{ $karyawan->created_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="valdo-divider" style="margin:0;"></div>
                    <div>
                        <p class="valdo-text-muted" style="font-size:0.7rem;margin-bottom:2px;">Terakhir diubah
                        </p>
                        <p style="color:#c8ccdc; font-size:0.8125rem; font-weight:500;">
                            {{ $karyawan->updated_at->format('d M Y, H:i') }}
                        </p>
                    </div>
                    <div class="valdo-divider" style="margin:0;"></div>
                    <div>
                        <p class="valdo-text-muted" style="font-size:0.7rem;margin-bottom:2px;">ID Sistem</p>
                        <p class="valdo-text-mono">#{{ str_pad($karyawan->id_karyawan, 4, '0', STR_PAD_LEFT) }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
