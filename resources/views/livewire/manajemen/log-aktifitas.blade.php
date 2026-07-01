<div>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
        <div>
            <h1 class="valdo-heading-lg">Log Aktivitas</h1>
            <p class="valdo-text-muted mt-1">Riwayat seluruh aktivitas sistem untuk keperluan audit</p>
        </div>
    </div>

    {{-- Filter Card --}}
    <div class="valdo-card mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">

            <div class="valdo-input-group lg:col-span-2" style="margin-bottom:0">
                <label class="valdo-label">Cari User</label>
                <input type="text" wire:model.live.debounce.400ms="search" class="valdo-input"
                    placeholder="Nama user...">
            </div>

            <div class="valdo-input-group" style="margin-bottom:0">
                <label class="valdo-label">Jenis Aksi</label>
                <div class="valdo-select-wrapper">
                    <select wire:model.live="filterAksi" class="valdo-select">
                        <option value="">Semua Aksi</option>
                        <option value="create">Tambah</option>
                        <option value="update">Update</option>
                        <option value="delete">Hapus</option>
                        <option value="verify">Verifikasi</option>
                        <option value="send_token">Kirim Token</option>
                    </select>
                </div>
            </div>

            <div class="valdo-input-group" style="margin-bottom:0">
                <label class="valdo-label">Modul</label>
                <div class="valdo-select-wrapper">
                    <select wire:model.live="filterTabel" class="valdo-select">
                        <option value="">Semua Modul</option>
                        <option value="karyawan">Karyawan</option>
                        <option value="klien">Klien</option>
                        <option value="penempatans">Penempatan</option>
                        <option value="evaluasi">Evaluasi</option>
                        <option value="kontrak_karyawan">Kontrak</option>
                        <option value="kriteria_penilaians">Kriteria Penilaian</option>
                    </select>
                </div>
            </div>

            <div class="valdo-input-group" style="margin-bottom:0">
                <label class="valdo-label">Dari Tanggal</label>
                <input type="date" wire:model.live="tanggalMulai" class="valdo-input">
            </div>

            <div class="valdo-input-group" style="margin-bottom:0">
                <label class="valdo-label">Sampai Tanggal</label>
                <input type="date" wire:model.live="tanggalSelesai" class="valdo-input">
            </div>
        </div>

        <div class="flex justify-end mt-4">
            <button wire:click="resetFilter" class="valdo-btn valdo-btn-ghost valdo-btn-sm">
                Reset Filter
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="valdo-table-wrapper" wire:loading.class="opacity-60">
        <table class="valdo-table">
            <thead>
                <tr>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Aksi</th>
                    <th>Modul</th>
                    <th>Target</th>
                    <th>IP Address</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($this->logs as $log)
                    @php $aksi = $this->labelAksi($log->aksi); @endphp
                    <tr wire:key="log-{{ $log->id_log }}">
                        <td>
                            <span class="valdo-text-mono" style="color:#a8adc4">
                                {{ $log->created_at->format('d M Y, H:i') }}
                            </span>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <span class="valdo-table-avatar">
                                    {{ strtoupper(substr($log->user?->name ?? 'S', 0, 1)) }}
                                </span>
                                <span>{{ $log->user?->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="valdo-badge {{ $aksi['badge'] }}">{{ $aksi['label'] }}</span>
                        </td>
                        <td>{{ $this->labelTabel($log->tabel_target) }}</td>
                        <td>
                            @if ($log->id_target)
                                <span class="valdo-text-mono">#{{ $log->id_target }}</span>
                            @else
                                <span class="valdo-text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="valdo-text-muted">{{ $log->ip_address ?? '-' }}</span>
                        </td>
                        <td>
                            @if ($log->data_lama || $log->data_baru)
                                <button wire:click="lihatDetail({{ $log->id_log }})"
                                    class="valdo-btn valdo-btn-ghost valdo-btn-sm">
                                    Detail
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center valdo-text-muted" style="padding:32px">
                            Tidak ada aktivitas yang cocok dengan filter.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $this->logs->links() }}
    </div>

    {{-- Modal Detail --}}
    <div class="valdo-modal-backdrop {{ $showDetail ? 'open' : '' }}" style="{{ $showDetail ? '' : 'display:none' }}"
        wire:click.self="tutupDetail">
        <div class="valdo-modal">
            <div class="valdo-modal-header">
                <h3 class="valdo-heading-md">Detail Perubahan Data</h3>
                <button wire:click="tutupDetail" class="valdo-modal-close" aria-label="Tutup">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18" />
                    </svg>
                </button>
            </div>

            <div class="valdo-modal-body">
                @if ($this->selectedLog)
                    <div class="mb-4">
                        <span class="valdo-text-label">Aksi</span>
                        @php $aksi = $this->labelAksi($this->selectedLog->aksi); @endphp
                        <div class="mt-1">
                            <span class="valdo-badge {{ $aksi['badge'] }}">{{ $aksi['label'] }}</span>
                            <span class="valdo-text-muted" style="margin-left:8px">
                                oleh {{ $this->selectedLog->user?->name ?? 'Sistem' }} ·
                                {{ $this->selectedLog->created_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="valdo-text-label">Data Sebelum</span>
                            <pre class="valdo-input-group mt-1"
                                style="background:var(--color-base-200); border-radius:var(--radius-input); padding:12px; box-shadow:var(--neu-inset); font-family:var(--font-mono); font-size:.75rem; color:#a8adc4; overflow-x:auto; white-space:pre-wrap">{{ $this->selectedLog->data_lama ? json_encode($this->selectedLog->data_lama, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '(kosong)' }}</pre>
                        </div>
                        <div>
                            <span class="valdo-text-label">Data Sesudah</span>
                            <pre class="valdo-input-group mt-1"
                                style="background:var(--color-base-200); border-radius:var(--radius-input); padding:12px; box-shadow:var(--neu-inset); font-family:var(--font-mono); font-size:.75rem; color:var(--color-accent-cyan); overflow-x:auto; white-space:pre-wrap">{{ $this->selectedLog->data_baru ? json_encode($this->selectedLog->data_baru, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : '(kosong)' }}</pre>
                        </div>
                    </div>
                @endif
            </div>

            <div class="valdo-modal-footer">
                <button wire:click="tutupDetail" class="valdo-btn valdo-btn-secondary">Tutup</button>
            </div>
        </div>
    </div>
</div>
