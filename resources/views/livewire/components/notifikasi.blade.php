<div wire:poll.30s="$refresh" class="relative" x-data="{ open: @entangle('open') }">
    <button @click="open = !open" class="valdo-icon-btn" aria-label="Log Aktivitas" :aria-expanded="open">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"
            aria-hidden="true">
            <path stroke-linecap="round"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>

        @if ($this->jumlahNotifikasi > 0)
            <span class="valdo-badge-dot" aria-label="{{ $this->jumlahNotifikasi }} aktivitas baru dalam 24 jam"></span>
        @endif
    </button>

    <div x-show="open" x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-1 scale-100"
        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-1"
        x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false" class="valdo-dropdown-menu"
        style="min-width:300px; padding-bottom:6px" role="region" aria-label="Log Aktivitas" x-cloak>

        <p
            style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#3d4263;padding:4px 12px 8px">
            Aktivitas Terbaru
        </p>

        {{-- area scroll: dibatasi tingginya biar ga manjang ke bawah --}}
        <div style="max-height:320px; overflow-y:auto; padding-right:2px">
            @forelse ($this->daftarNotifikasi as $item)
                <div class="valdo-dropdown-item"
                    style="flex-direction:column;align-items:flex-start;gap:4px;cursor:default">
                    <span class="valdo-badge {{ $item['badge'] }}" style="font-size:.6rem">
                        {{ strtoupper($item['aksi']) }}
                    </span>
                    <span style="font-size:.82rem;color:#c8ccdc;font-weight:500">
                        {{ $item['deskripsi'] }}
                    </span>
                    <span style="font-size:.72rem;color:#4a5070">
                        {{ $item['waktu']->diffForHumans() }}
                    </span>
                </div>
            @empty
                <div class="valdo-dropdown-item" style="justify-content:center;color:#4a5070;font-size:.8rem">
                    Belum ada aktivitas
                </div>
            @endforelse
        </div>

        @auth
            @if (auth()->user()->isManajemen())
                <div class="valdo-dropdown-divider"></div>
                <a href="{{ route('manajemen.log-aktivitas') }}" wire:navigate class="valdo-dropdown-item"
                    style="justify-content:center;color:var(--color-accent-blue);font-size:.8rem;font-weight:600">
                    Lihat semua log aktivitas
                </a>
            @endif
        @endauth
    </div>
</div>
