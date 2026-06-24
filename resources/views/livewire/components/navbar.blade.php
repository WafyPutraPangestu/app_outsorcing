<div x-data="{
    collapsed: false,
    mobileOpen: false,
    search: '',
    isDesktop: window.innerWidth >= 1024,
    init() {
        const checkSize = () => {
            this.isDesktop = window.innerWidth >= 1024;
            if (this.isDesktop) {
                this.mobileOpen = false;
            } else {
                this.collapsed = false;
            }
        };
        window.addEventListener('resize', checkSize);
    }
}" x-cloak>

    {{-- ═══════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════ --}}
    <aside
        :class="{
            'collapsed': collapsed && window.innerWidth >= 1024,
            'mobile-open': mobileOpen && window.innerWidth < 1024
        }"
        class="valdo-sidebar">
        {{-- Toggle collapse (desktop only) --}}
        <button @click="collapsed = !collapsed"
            class="hidden lg:flex absolute top-6 -right-2.5 w-6.5 h-6.5 rounded-full items-center justify-center cursor-pointer z-10
                   text-[#6b7190] border border-white/10 transition-all duration-200
                   hover:text-[var(--color-accent-blue)] hover:border-[rgba(79,142,247,0.3)]"
            style="background:var(--color-base-300); box-shadow:var(--neu-shadow-sm);"
            :title="collapsed ? 'Perluas sidebar' : 'Tutup sidebar'" aria-label="Toggle sidebar">
            <svg :class="collapsed ? 'rotate-180' : ''" class="w-3.5 h-3.5 transition-transform duration-250"
                fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- ── Logo ── --}}
        <div class="valdo-sidebar-logo">
            <div class="valdo-sidebar-logo-icon" aria-hidden="true">
                <img src="{{ asset('images/logo/logoo.png') }}" alt="Logo PT Valdo" class="w-8 h-8 object-contain"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                <span style="display:none" aria-hidden="true">V</span>
            </div>
            <div class="valdo-sidebar-logo-text">
                <span class="block" style="font-size:1.05rem;font-weight:700;color:#000;line-height:1.2">PT
                    Valdo</span>
                <span class="block"
                    style="font-size:.65rem;color:var(--color-accent-blue);font-weight:600;text-transform:uppercase;letter-spacing:.08em">Outsourcing
                    System</span>
            </div>
        </div>

        {{-- ── Navigation ── --}}
        <nav class="valdo-sidebar-nav" aria-label="Navigasi utama">

            {{-- ──── ADMIN SECTION ──── --}}
            @can('admin')
                <p class="valdo-sidebar-section-label">Admin</p>

                {{-- Dashboard --}}
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" />
                            <rect x="14" y="3" width="7" height="7" rx="1.5" />
                            <rect x="3" y="14" width="7" height="7" rx="1.5" />
                            <rect x="14" y="14" width="7" height="7" rx="1.5" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Dashboard</span>
                </a>

                {{-- Manajemen Karyawan --}}
                <a href="{{ route('admin.karyawan.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.karyawan.*') ? 'active' : '' }}"
                    title="Manajemen Karyawan">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <circle cx="9" cy="7" r="4" />
                            <path stroke-linecap="round" d="M3 21v-2a4 4 0 014-4h4a4 4 0 014 4v2" />
                            <path stroke-linecap="round" d="M16 3.13a4 4 0 010 7.75" />
                            <path stroke-linecap="round" d="M21 21v-2a4 4 0 00-3-3.85" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Manajemen Karyawan</span>
                </a>

                {{-- Manajemen Klien --}}
                <a href="{{ route('admin.klien.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.klien.index*') ? 'active' : '' }}"
                    title="Manajemen Klien">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" d="M3 21h18M3 7l9-4 9 4M4 7v14M20 7v14M9 21v-4a2 2 0 114 0v4" />
                            <path stroke-linecap="round" d="M9 11h.01M15 11h.01" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Manajemen Klien</span>
                </a>

                {{-- Kriteria Penilaian --}}
                <a href="{{ route('admin.kriteria.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.kriteria.index*') ? 'active' : '' }}"
                    title="Kriteria Penilaian">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M9 12l2 2 4-4" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Kriteria Penilaian</span>
                </a>

                {{-- Penempatan --}}
                <a href="{{ route('admin.penempatan.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.penempatan.index*') ? 'active' : '' }}"
                    title="Penempatan">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <circle cx="12" cy="11" r="3" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Penempatan</span>
                </a>

                {{-- Manajemen Penilaian --}}
                <a href="{{ route('admin.evaluasi.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.evaluasi.index*') ? 'active' : '' }}"
                    title="Manajemen Penilaian">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Manajemen Penilaian</span>
                    {{-- Badge evaluasi pending (optional, bisa diisi dari component --}}
                    @php $pendingCount = 0; @endphp
                    @if ($pendingCount > 0)
                        <span class="ml-auto text-[.65rem] font-bold px-2 py-0.5 rounded-full shrink-0"
                            style="background:rgba(79,142,247,0.18);color:var(--color-accent-blue);border:1px solid rgba(79,142,247,0.25)">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>
                {{-- Manajemen Kontrak --}}
                <a href="{{ route('admin.kontrak.index') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('admin.kontrak.*') ? 'active' : '' }}"
                    title="Manajemen Kontrak">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <rect x="6" y="4" width="12" height="17" rx="2" />
                            <path stroke-linecap="round" d="M9 4V3a1 1 0 011-1h4a1 1 0 011 1v1" />
                            <path stroke-linecap="round" d="M9 12l2 2 4-4" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Manajemen Kontrak</span>
                    {{-- Badge kontrak hampir habis (optional, bisa diisi dari component) --}}
                    @php $kontrakHampirHabisCount = 0; @endphp
                    @if ($kontrakHampirHabisCount > 0)
                        <span class="ml-auto text-[.65rem] font-bold px-2 py-0.5 rounded-full shrink-0"
                            style="background:rgba(232,121,249,0.18);color:var(--color-accent-pink);border:1px solid rgba(232,121,249,0.25)">
                            {{ $kontrakHampirHabisCount }}
                        </span>
                    @endif
                </a>
            @endcan

            {{-- ──── MANAJEMEN SECTION ──── --}}
            @can('manajemen')
                <div class="valdo-sidebar-section-label" style="margin-top:6px">Manajemen</div>

                {{-- Dashboard Manajer --}}
                <a href="{{ route('manajemen.dashboard') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('manajemen.dashboard') ? 'active' : '' }}"
                    title="Dashboard">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Dashboard</span>
                </a>

                {{-- Verifikasi Nilai --}}
                <a href="{{ route('manajemen.verifikasi') }}" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('manajemen.verifikasi.*') ? 'active' : '' }}"
                    title="Verifikasi Nilai">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Verifikasi Nilai</span>
                </a>

                {{-- Log Aktivitas --}}
                <a href="#" wire:navigate
                    class="valdo-nav-item {{ request()->routeIs('manajemen.log.*') ? 'active' : '' }}"
                    title="Log Aktivitas">
                    <span class="valdo-nav-item-icon" aria-hidden="true">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2M12 11v4M10 13h4" />
                        </svg>
                    </span>
                    <span class="valdo-nav-item-label">Log Aktivitas</span>
                </a>
            @endcan

            {{-- ──── GENERAL ──── --}}
            <div class="valdo-sidebar-section-label" style="margin-top:6px">Umum</div>

            <a href="{{ route('home') }}" wire:navigate
                class="valdo-nav-item {{ request()->routeIs('home') ? 'active' : '' }}" title="Home">
                <span class="valdo-nav-item-icon" aria-hidden="true">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </span>
                <span class="valdo-nav-item-label">Home</span>
            </a>

        </nav>

        @auth
            {{-- ── User Footer ── --}}
            <div class="valdo-sidebar-footer">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="valdo-sidebar-user w-full text-left" aria-haspopup="true"
                        :aria-expanded="open">
                        <div class="valdo-user-avatar" aria-hidden="true">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="valdo-sidebar-user-info">
                            <p
                                style="font-size:.85rem;font-weight:600;color:#c8ccdc;line-height:1.2;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                                {{ auth()->user()->name ?? 'Guest' }}
                            </p>
                            <p
                                style="font-size:.7rem;color:var(--color-accent-blue);font-weight:600;text-transform:uppercase;letter-spacing:.06em">
                                {{ ucfirst(auth()->user()->role ?? '') }}
                            </p>
                        </div>
                        <svg class="w-3.5 h-3.5 text-[#6b7190] flex-shrink-0 transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2.5"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- User dropdown --}}
                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                        x-transition:enter-end="opacity-1 scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-100"
                        x-transition:leave-start="opacity-1 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.outside="open = false" class="valdo-dropdown-menu"
                        style="bottom:calc(100% + 8px);top:auto;left:0;right:0;min-width:0" role="menu">

                        <a href="#" wire:navigate class="valdo-dropdown-item" role="menuitem">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil Saya
                        </a>
                        <a href="#" wire:navigate class="valdo-dropdown-item" role="menuitem">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Ganti Password
                        </a>
                        <div class="valdo-dropdown-divider"></div>



                        <form wire:submit.prevent="logout">

                            <button type="submit" class="valdo-dropdown-item danger w-full text-left" role="menuitem">
                                <svg width="16" height="16" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </aside>

    {{-- ═══════════════════════════════════════════
         TOPBAR
    ═══════════════════════════════════════════ --}}
    <header class="valdo-topbar" :class="collapsed ? 'sidebar-collapsed' : ''">

        {{-- Hamburger (mobile) --}}
        <button @click="mobileOpen = !mobileOpen" class="valdo-icon-btn" style="display:none"
            x-init="$el.style.display = window.innerWidth < 1024 ? 'flex' : 'none'" @resize.window="$el.style.display = window.innerWidth < 1024 ? 'flex' : 'none'"
            aria-label="Buka menu navigasi" :aria-expanded="mobileOpen">
            <svg x-show="!mobileOpen" width="20" height="20" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="mobileOpen" width="20" height="20" fill="none" stroke="currentColor"
                stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Breadcrumb --}}
        <nav aria-label="Breadcrumb" class="hidden sm:flex items-center gap-1.5 text-sm text-[#4a5070]">
            <span>PT Valdo</span>
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-[#000] font-semibold">
                {{ ucfirst(last(request()->segments()) ?: 'Home') }}
            </span>
        </nav>
        @auth

            {{-- Search --}}
            <div class="valdo-search">
                {{-- <svg class="valdo-search-icon" width="16" height="16" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="11" cy="11" r="8" />
                    <path stroke-linecap="round" d="M21 21l-4.35-4.35" />
                </svg> --}}
                {{-- <input type="search" class="valdo-search-input" placeholder="Cari karyawan, klien, evaluasi…"
                    x-model="search" aria-label="Pencarian"> --}}
            </div>
        @endauth

        {{-- Topbar actions --}}
        <div class="valdo-topbar-actions">

            {{-- Notifikasi --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="valdo-icon-btn" aria-label="Notifikasi" :aria-expanded="open">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="1.8"
                        viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="valdo-badge-dot" aria-label="Ada notifikasi baru"></span>
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-1 scale-100"
                    x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-1"
                    x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false"
                    class="valdo-dropdown-menu" style="min-width:280px" role="region" aria-label="Notifikasi">
                    <p
                        style="font-size:.7rem;font-weight:700;text-transform:uppercase;letter-spacing:.08em;color:#3d4263;padding:4px 12px 8px">
                        Notifikasi Terbaru
                    </p>
                    <div class="valdo-dropdown-item" style="flex-direction:column;align-items:flex-start;gap:2px">
                        <span style="font-size:.82rem;color:#c8ccdc;font-weight:500">Evaluasi baru menunggu
                            verifikasi</span>
                        <span style="font-size:.72rem;color:#4a5070">2 menit lalu</span>
                    </div>
                    <div class="valdo-dropdown-item" style="flex-direction:column;align-items:flex-start;gap:2px">
                        <span style="font-size:.82rem;color:#c8ccdc;font-weight:500">Kontrak Ahmad Fauzi hampir
                            habis</span>
                        <span style="font-size:.72rem;color:#4a5070">1 jam lalu</span>
                    </div>
                    <div class="valdo-dropdown-divider"></div>
                    <a href="#" wire:navigate class="valdo-dropdown-item"
                        style="justify-content:center;color:var(--color-accent-blue);font-size:.8rem;font-weight:600">
                        Lihat semua notifikasi
                    </a>
                </div>
            </div>

            {{-- Divider vertical --}}
            <div class="valdo-divider-vertical hidden sm:block" style="height:28px"></div>
            @auth


                {{-- User avatar (topbar) --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-2.5 px-2 py-1.5 rounded-xl cursor-pointer transition-all duration-150 hover:opacity-80"
                        style="background:var(--color-base-300);border:1px solid rgba(255,255,255,0.05);box-shadow:var(--neu-shadow-sm)"
                        :aria-expanded="open" aria-haspopup="true" aria-label="Menu pengguna">
                        <div class="valdo-user-avatar" style="width:30px;height:30px;font-size:11px" aria-hidden="true">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}
                        </div>
                        <div class="hidden sm:block text-left">
                            <p style="font-size:.8rem;font-weight:600;color:#c8ccdc;line-height:1.1;white-space:nowrap">
                                {{ auth()->user()->name ?? 'Guest' }}
                            </p>
                            <p
                                style="font-size:.65rem;color:var(--color-accent-blue);font-weight:600;text-transform:uppercase;letter-spacing:.06em">
                                {{ ucfirst(auth()->user()->role ?? '') }}
                            </p>
                        </div>
                        <svg class="w-3 h-3 text-[#6b7190] hidden sm:block transition-transform duration-200"
                            :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="3"
                            viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-150"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-1 scale-100"
                        x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-1"
                        x-transition:leave-end="opacity-0 scale-95" @click.outside="open = false"
                        class="valdo-dropdown-menu" role="menu">
                        <a href="#" wire:navigate class="valdo-dropdown-item" role="menuitem">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                                <circle cx="12" cy="7" r="4" />
                            </svg>
                            Profil Saya
                        </a>
                        <a href="#" wire:navigate class="valdo-dropdown-item" role="menuitem">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" aria-hidden="true">
                                <circle cx="12" cy="12" r="3" />
                                <path stroke-linecap="round"
                                    d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z" />
                            </svg>
                            Pengaturan
                        </a>
                        <div class="valdo-dropdown-divider"></div>
                        <form wire:submit.prevent="logout">
                            <button type="submit" class="valdo-dropdown-item danger w-full text-left" role="menuitem">
                                <svg width="16" height="16" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth
        </div>
    </header>

    {{-- ═══════════════════════════════════════════
         MOBILE OVERLAY
    ═══════════════════════════════════════════ --}}
    <div x-show="mobileOpen" @click="mobileOpen = false"
        x-transition:enter="transition-opacity ease-linear duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 lg:hidden" aria-hidden="true"></div>

    {{-- Guest login button (topbar, if applicable) --}}
    @guest
        <div style="position:fixed;top:12px;right:16px;z-index:60">
            <a href="{{ route('login') }}" wire:navigate class="valdo-btn valdo-btn-primary valdo-btn-sm">
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                </svg>
                Login
            </a>
        </div>
    @endguest

    {{-- Livewire loading bar --}}
    <div wire:loading.delay class="valdo-wire-loading-bar" aria-hidden="true"></div>

</div>
