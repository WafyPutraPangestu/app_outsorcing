<div>
    <nav>
        <div class="">
            {{-- disini logo pathnya:D:\JOKI RAHARJA\OUTSORCING\sistem\app_outsorcing\public\images\logo\logo.png --}}
        </div>
        <ul>
            <li><a href="{{ route('home') }}" wire:navigate>Home</a></li>
            @can('admin')
                <li><a href="#" wire:navigate>Dashboard</a></li>
                <li><a href="#" wire:navigate>Manajemen Karyawan</a></li>
                <li><a href="#" wire:navigate>Manajemen Klien</a></li>
                <li><a href="#" wire:navigate>Kriteria Penilaian</a></li>
                <li><a href="#" wire:navigate>Penempatan</a></li>
                <li><a href="#" wire:navigate>Manajemen Penilaian</a></li>
            @endcan

            @can('manajement')
                <li><a href="#" wire:navigate>Dashboard</a></li>
                <li><a href="#" wire:navigate>Verifikasi Nilai</a></li>
                <li><a href="#" wire:navigate>Log Aktifitas</a></li>
            @endcan

        </ul>
        <div class="">
            @guest
                <a href="{{ route('login') }}" wire:navigate>Login</a>
            @endguest
        </div>
    </nav>
</div>
