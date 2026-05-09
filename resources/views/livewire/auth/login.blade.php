<div class="min-h-screen flex items-center justify-center relative overflow-hidden"
    style="background-color: var(--color-base-100);">

    {{-- Background ambient glow blobs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div
            style="
            position: absolute; top: -10%; left: -15%;
            width: 600px; height: 600px; border-radius: 50%;
            background: radial-gradient(circle, rgba(79,142,247,0.08) 0%, transparent 70%);
            filter: blur(40px);
        ">
        </div>
        <div
            style="
            position: absolute; bottom: -15%; right: -10%;
            width: 500px; height: 500px; border-radius: 50%;
            background: radial-gradient(circle, rgba(139,92,246,0.08) 0%, transparent 70%);
            filter: blur(40px);
        ">
        </div>
        <div
            style="
            position: absolute; top: 40%; left: 50%; transform: translate(-50%,-50%);
            width: 300px; height: 300px; border-radius: 50%;
            background: radial-gradient(circle, rgba(34,211,238,0.04) 0%, transparent 70%);
            filter: blur(60px);
        ">
        </div>
    </div>

    {{-- Card --}}
    <div class="relative w-full max-w-md mx-4">

        {{-- Gradient border wrapper --}}
        <div
            style="
            position: relative; border-radius: 20px; padding: 1px;
            background: linear-gradient(135deg, rgba(79,142,247,0.3), rgba(139,92,246,0.2), rgba(34,211,238,0.15));
            box-shadow: 0 30px 80px rgba(0,0,0,0.5), 0 0 60px rgba(79,142,247,0.05);
        ">
            <div
                style="
                background: var(--color-base-300);
                border-radius: 19px;
                padding: 40px 36px 36px;
                position: relative;
                overflow: hidden;
            ">

                {{-- Subtle top shimmer --}}
                <div
                    style="
                    position: absolute; top: 0; left: 0; right: 0; height: 1px;
                    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1) 40%, rgba(255,255,255,0.1) 60%, transparent);
                ">
                </div>

                {{-- Logo & Header --}}
                <div class="text-center mb-8">
                    <div class="flex items-center justify-center gap-3 mb-5">
                        {{-- Logo icon --}}
                        <div
                            style="
                            width: 48px; height: 48px; border-radius: 14px;
                            background: linear-gradient(135deg, var(--color-accent-blue), var(--color-accent-purple));
                            box-shadow: 0 0 24px var(--glow-blue), 0 8px 20px rgba(0,0,0,0.4);
                            display: flex; align-items: center; justify-content: center;
                            font-weight: 800; font-size: 18px; color: #fff; letter-spacing: -0.04em;
                            font-family: var(--font-sans);
                        ">
                            V</div>
                        <div style="text-align: left;">
                            <div
                                style="font-size: 1.2rem; font-weight: 800; color: #e2e5f0; letter-spacing: -0.03em; line-height: 1.1;">
                                PT Valdo</div>
                            <div class="valdo-text-mono" style="font-size: 0.7rem; letter-spacing: 0.1em;">OUTSOURCING
                                SYSTEM</div>
                        </div>
                    </div>

                    <h1
                        style="font-size: 1.5rem; font-weight: 700; color: #e2e5f0; letter-spacing: -0.02em; margin-bottom: 6px;">
                        Selamat Datang
                    </h1>
                    <p class="valdo-text-muted">Masuk ke panel manajemen karyawan</p>
                </div>

                {{-- Form --}}
                <form wire:submit="login" novalidate>

                    {{-- Global error --}}
                    @if ($errors->has('email') && !$errors->first('email') == 'Email wajib diisi.')
                        <div
                            style="
                            background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2);
                            border-radius: 10px; padding: 12px 14px; margin-bottom: 16px;
                            display: flex; align-items: center; gap: 10px;
                        ">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#f87171"
                                stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <span
                                style="color: #f87171; font-size: 0.8rem; font-weight: 500;">{{ $errors->first('email') }}</span>
                        </div>
                    @endif

                    {{-- Email --}}
                    <div class="valdo-input-group">
                        <label class="valdo-label" for="email">Alamat Email</label>
                        <div class="valdo-input-wrapper">
                            <span class="valdo-input-prefix">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path
                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input wire:model="email" type="email" id="email" placeholder="admin@valdo.co.id"
                                autocomplete="email" class="valdo-input @error('email') error @enderror" />
                        </div>
                        @error('email')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="valdo-input-group" x-data="{ show: false }">
                        <label class="valdo-label" for="password">Password</label>

                        {{-- Wrapper utama harus RELATIVE --}}
                        <div style="position: relative; width: 100%; display: flex; align-items: center;">

                            {{-- Icon Gembok (Kiri) --}}
                            <div
                                style="position: absolute; left: 14px; display: flex; align-items: center; pointer-events: none; color: #3d4263; z-index: 10;">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </div>

                            {{-- Input (Pastikan padding kiri & kanan cukup) --}}
                            <input wire:model="password" :type="show ? 'text' : 'password'" id="password"
                                placeholder="••••••••" autocomplete="current-password"
                                class="valdo-input relative @error('password') error @enderror"
                                style="width: 100%; padding-left: 40px; padding-right: 45px; margin: 0;" />

                            {{-- Toggle Mata (Kanan) --}}
                            <button type="button" @click="show = !show"
                                style="
                position: absolute; 
                right: 14px; 
                top: 50%; 
                transform: translateY(-50%);
                background: none; 
                border: none; 
                cursor: pointer;
                display: flex; 
                align-items: center; 
                padding: 0;
                z-index: 20;
                color: #3d4263;
            "
                                :style="show ? 'color: var(--color-accent-blue)' : ''">

                                <svg x-show="!show" width="18" height="18" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>

                                <svg x-show="show" x-cloak width="18" height="18" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                    <path
                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24" />
                                    <line x1="1" y1="1" x2="23" y2="23" />
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <span class="valdo-input-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center justify-between mb-6" style="margin-top: 4px;">
                        <label class="valdo-checkbox-wrapper" style="cursor: pointer; user-select: none;">
                            <div class="valdo-checkbox {{ $remember ? 'checked' : '' }}"
                                wire:click="$toggle('remember')">
                                @if ($remember)
                                    <svg width="10" height="10" fill="none" viewBox="0 0 24 24"
                                        stroke="#fff" stroke-width="3.5">
                                        <polyline points="20 6 9 17 4 12" />
                                    </svg>
                                @endif
                            </div>
                            <span style="font-size: 0.85rem; color: #8892b0; font-weight: 500;">Ingat saya</span>
                        </label>
                    </div>

                    {{-- Submit button --}}
                    <button type="submit" class="valdo-btn valdo-btn-primary"
                        style="width: 100%; justify-content: center; padding: 12px 20px; font-size: 0.9375rem;">
                        <span wire:loading.remove>
                            <span style="display: flex; align-items: center; gap: 8px; justify-content: center;">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                                    <polyline points="10 17 15 12 10 7" />
                                    <line x1="15" y1="12" x2="3" y2="12" />
                                </svg>
                                Masuk ke Sistem
                            </span>
                        </span>

                        <span wire:loading class="inline-flex items-center gap-2">

                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2"
                                style="animation: valdo-spin 0.7s linear infinite;">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56" />
                            </svg>

                            <span>Memproses...</span>

                        </span>


                    </button>
                </form>

                {{-- Footer --}}
                <div
                    style="margin-top: 28px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.04); text-align: center;">
                    <p style="font-size: 0.75rem; color: #3d4263; line-height: 1.6;">
                        Sistem ini hanya untuk pengguna yang berwenang.<br>
                        <span style="color: var(--color-accent-blue); opacity: 0.7;">PT Valdo Outsourcing
                            Management</span>
                    </p>
                </div>

            </div>
        </div>

        {{-- Version tag --}}
        <div style="text-align: center; margin-top: 16px;">
            <span class="valdo-text-mono" style="font-size: 0.65rem; opacity: 0.3;">v1.0.0 · Valdo OS</span>
        </div>
    </div>
</div>
