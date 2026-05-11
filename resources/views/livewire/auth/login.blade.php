<div class="min-h-screen flex items-center justify-center  relative  overflow-hidden">

    {{-- Background ambient orbs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full"
            style="background: radial-gradient(circle, rgba(79,142,247,0.08) 0%, transparent 70%);"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 rounded-full"
            style="background: radial-gradient(circle, rgba(139,92,246,0.08) 0%, transparent 70%);"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full"
            style="background: radial-gradient(circle, rgba(34,211,238,0.03) 0%, transparent 70%);"></div>
    </div>

    {{-- Grid pattern overlay --}}
    <div class="pointer-events-none absolute inset-0"
        style="background-image: linear-gradient(rgba(255,255,255,0.015) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.015) 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    {{-- Login Card --}}
    <div class="w-full max-w-md relative z-10">

        {{-- Logo & Brand --}}
        <div class="flex flex-col items-center mb-8">
            <div class="valdo-float mb-5">
                <div class="relative">
                    {{-- Glow ring --}}
                    <div class="absolute inset-0 rounded-2xl blur-xl opacity-60"
                        style="background: linear-gradient(135deg, var(--color-accent-blue), var(--color-accent-purple));">
                    </div>
                    {{-- Logo box --}}
                    <div class="relative w-16 h-16 rounded-2xl flex items-center justify-center font-bold text-white text-2xl tracking-tight"
                        style="background: linear-gradient(135deg, var(--color-accent-blue), var(--color-accent-purple)); box-shadow: 0 0 32px var(--glow-blue); font-family: var(--font-mono);">
                        V
                    </div>
                </div>
            </div>
            <h1 class="valdo-heading-lg text-center mb-1">PT Valdo</h1>
            <p class="valdo-text-muted text-center">Sistem Manajemen Outsourcing</p>
        </div>

        {{-- Card --}}
        <div class="valdo-card" style="padding: 32px;">

            {{-- Card top shimmer accent --}}
            <div class="absolute top-0 left-8 right-8 h-px"
                style="background: linear-gradient(90deg, transparent, rgba(79,142,247,0.4), rgba(139,92,246,0.4), transparent);">
            </div>

            <div class="mb-6">
                <h2 class="valdo-heading-md mb-1">Selamat Datang</h2>
                <p class="valdo-text-muted text-sm">Masuk ke akun admin Anda untuk melanjutkan</p>
            </div>

            {{-- Form --}}
            <form wire:submit.prevent="login" class="space-y-5">

                {{-- Email --}}
                <div class="valdo-input-group" style="margin-bottom: 0;">
                    <label for="email" class="valdo-label">Email</label>
                    <div class="valdo-input-wrapper">
                        <span class="valdo-input-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </span>
                        <input id="email" type="email" wire:model="email" placeholder="admin@ptvaldo.co.id"
                            class="valdo-input @error('email') error @enderror" autocomplete="email" />
                    </div>
                    @error('email')
                        <p class="valdo-input-error flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="valdo-input-group" style="margin-bottom: 0;" x-data="{ show: false }">
                    <label for="password" class="valdo-label">Password</label>
                    <div class="valdo-input-wrapper" style="position: relative;">
                        <span class="valdo-input-prefix">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                        </span>
                        <input id="password" :type="show ? 'text' : 'password'" wire:model="password"
                            placeholder="••••••••" class="valdo-input @error('password') error @enderror"
                            style="padding-right: 42px;" autocomplete="current-password" />
                        {{-- Toggle show password --}}
                        <button type="button" @click="show = !show"
                            class="absolute right-3 top-1/2 -translate-y-1/2 transition-colors"
                            style="color: #3d4263; background: none; border: none; cursor: pointer; display: flex; align-items: center;"
                            :style="show ? 'color: var(--color-accent-blue)' : ''">
                            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                <circle cx="12" cy="12" r="3" />
                            </svg>
                            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                                <path
                                    d="M9.88 9.88a3 3 0 1 0 4.24 4.24M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68" />
                                <path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61" />
                                <line x1="2" x2="22" y1="2" y2="22" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="valdo-input-error flex items-center gap-1 mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" x2="12" y1="8" y2="12" />
                                <line x1="12" x2="12.01" y1="16" y2="16" />
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- Remember me --}}
                <div class="flex items-center justify-between pt-1">
                    <label class="valdo-checkbox-wrapper" style="cursor: pointer;">
                        <div class="valdo-checkbox {{ $remember ? 'checked' : '' }}" wire:click="$toggle('remember')"
                            style="cursor: pointer;">
                            @if ($remember)
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11"
                                    viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="3"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            @endif
                        </div>
                        <span class="text-sm" style="color: #8892b0;">Ingat saya</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="valdo-btn valdo-btn-primary w-full mt-2"
                    style="height: 44px; font-size: 0.9375rem;" wire:loading.class="loading" wire:target="login">
                    <span wire:loading.remove wire:target="login" class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" x2="3" y1="12" y2="12" />
                        </svg>
                        Masuk ke Sistem
                    </span>
                    <span wire:loading wire:target="login" class="flex items-center gap-2">
                        Memverifikasi...
                    </span>
                </button>

            </form>

        </div>

        {{-- Footer --}}
        <p class="text-center mt-6" style="font-size: 0.75rem; color: #3d4263;">
            © {{ date('Y') }} PT Valdo · Sistem Manajemen Outsourcing
        </p>

    </div>

</div>
