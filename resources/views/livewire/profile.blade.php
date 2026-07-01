<div class="max-w-3xl mx-auto flex flex-col gap-6">

    {{-- Header --}}
    <div>
        <h1 class="valdo-heading-lg">Profil Saya</h1>
        <p class="valdo-text-muted mt-1">Kelola informasi akun dan keamanan login kamu.</p>
    </div>

    {{-- ═══════════ CARD: Ringkasan Akun ═══════════ --}}
    <div class="valdo-card flex items-center gap-4">
        <div class="valdo-user-avatar" style="width:56px;height:56px;font-size:1.1rem">
            {{ strtoupper(substr($name ?: 'U', 0, 2)) }}
        </div>
        <div class="flex-1 min-w-0">
            <p style="font-size:1rem;font-weight:700;color:#e2e5f0">{{ $name }}</p>
            <p class="valdo-text-muted">{{ $email }}</p>
        </div>
        <span class="valdo-badge valdo-badge-blue">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>

    {{-- ═══════════ CARD: Info Profil ═══════════ --}}
    <div class="valdo-card">
        <div class="valdo-card-header">
            <div>
                <h2 class="valdo-heading-md">Informasi Profil</h2>
                <p class="valdo-text-muted">Perbarui nama dan email akun kamu.</p>
            </div>
        </div>

        @if (session('profile_success'))
            <div class="valdo-badge valdo-badge-green mb-4" style="display:flex;width:fit-content">
                {{ session('profile_success') }}
            </div>
        @endif

        <form wire:submit="updateProfile">
            <div class="valdo-input-group">
                <label class="valdo-label" for="name">Nama Lengkap</label>
                <input id="name" type="text" wire:model="name"
                    class="valdo-input @error('name') error @enderror" placeholder="Masukkan nama lengkap">
                @error('name')
                    <span class="valdo-input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="valdo-input-group">
                <label class="valdo-label" for="email">Email</label>
                <input id="email" type="email" wire:model="email"
                    class="valdo-input @error('email') error @enderror" placeholder="nama@email.com">
                @error('email')
                    <span class="valdo-input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-end mt-2">
                <button type="submit" class="valdo-btn valdo-btn-primary" wire:loading.attr="disabled"
                    wire:target="updateProfile">
                    <span wire:loading.remove wire:target="updateProfile">Simpan Perubahan</span>
                    <span wire:loading wire:target="updateProfile">Menyimpan...</span>
                </button>
            </div>
        </form>
    </div>

    {{-- ═══════════ CARD: Ganti Password ═══════════ --}}
    <div class="valdo-card">
        <div class="valdo-card-header">
            <div>
                <h2 class="valdo-heading-md">Ganti Password</h2>
                <p class="valdo-text-muted">Gunakan password yang kuat dan tidak dipakai di tempat lain.</p>
            </div>
        </div>

        @if (session('password_success'))
            <div class="valdo-badge valdo-badge-green mb-4" style="display:flex;width:fit-content">
                {{ session('password_success') }}
            </div>
        @endif

        <form wire:submit="updatePassword">
            <div class="valdo-input-group">
                <label class="valdo-label" for="current_password">Password Saat Ini</label>
                <input id="current_password" type="password" wire:model="current_password"
                    class="valdo-input @error('current_password') error @enderror" placeholder="••••••••"
                    autocomplete="current-password">
                @error('current_password')
                    <span class="valdo-input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="valdo-input-group">
                <label class="valdo-label" for="new_password">Password Baru</label>
                <input id="new_password" type="password" wire:model="new_password"
                    class="valdo-input @error('new_password') error @enderror" placeholder="Minimal 8 karakter"
                    autocomplete="new-password">
                @error('new_password')
                    <span class="valdo-input-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="valdo-input-group">
                <label class="valdo-label" for="new_password_confirmation">Konfirmasi Password Baru</label>
                <input id="new_password_confirmation" type="password" wire:model="new_password_confirmation"
                    class="valdo-input" placeholder="Ulangi password baru" autocomplete="new-password">
            </div>

            <div class="flex justify-end mt-2">
                <button type="submit" class="valdo-btn valdo-btn-secondary" wire:loading.attr="disabled"
                    wire:target="updatePassword">
                    <span wire:loading.remove wire:target="updatePassword">Ubah Password</span>
                    <span wire:loading wire:target="updatePassword">Memproses...</span>
                </button>
            </div>
        </form>
    </div>

</div>
