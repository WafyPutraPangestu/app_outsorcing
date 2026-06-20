<div x-data="homeCtrl()" x-init="init()" class="relative w-full overflow-x-hidden"
    style="background:var(--color-base-100);">

    {{-- ═══════════════════════════════════════════════════════
         CURSOR GLOW
    ═══════════════════════════════════════════════════════ --}}
    <div id="cursor-glow" class="pointer-events-none fixed z-50 rounded-full"
        style="width:400px;height:400px;margin-left:-200px;margin-top:-200px;
                background:radial-gradient(circle,rgba(79,142,247,0.07) 0%,transparent 70%);
                transition:opacity 0.3s ease;opacity:0;will-change:transform;">
    </div>

    {{-- ═══════════════════════════════════════════════════════
         HERO — Cinematic Full Screen
    ═══════════════════════════════════════════════════════ --}}
    <section id="hero" class="relative w-full overflow-hidden flex items-center justify-center"
        style="min-height:100svh;">

        {{-- Layered Background --}}
        <div class="absolute inset-0">
            {{-- Base photo --}}
            <img id="hero-bg-img" src="{{ asset('images/asset/meeting.png') }}" alt=""
                class="absolute inset-0 w-full h-full object-cover object-center"
                style="transform:scale(1.08);will-change:transform;filter:saturate(0.5) brightness(0.45);">

            {{-- Color grading overlay --}}
            <div class="absolute inset-0"
                style="background:linear-gradient(160deg,
                    rgba(13,15,26,0.92) 0%,
                    rgba(13,15,26,0.6) 35%,
                    rgba(79,142,247,0.15) 60%,
                    rgba(139,92,246,0.4) 100%);">
            </div>

            {{-- Vignette --}}
            <div class="absolute inset-0"
                style="background:radial-gradient(ellipse 80% 80% at 50% 50%,transparent 40%,rgba(0,0,0,0.7) 100%);">
            </div>

            {{-- Scan-lines texture --}}
            <div class="absolute inset-0 pointer-events-none"
                style="background-image:repeating-linear-gradient(0deg,transparent,transparent 2px,rgba(0,0,0,0.03) 2px,rgba(0,0,0,0.03) 4px);opacity:0.4;">
            </div>

            {{-- Noise grain --}}
            <div class="absolute inset-0 pointer-events-none"
                style="opacity:0.12;background-image:url('data:image/svg+xml,%3Csvg xmlns%3D%22http%3A//www.w3.org/2000/svg%22 width%3D%22200%22 height%3D%22200%22%3E%3Cfilter id%3D%22n%22%3E%3CfeTurbulence type%3D%22fractalNoise%22 baseFrequency%3D%220.9%22 numOctaves%3D%224%22 stitchTiles%3D%22stitch%22/%3E%3C/filter%3E%3Crect width%3D%22200%22 height%3D%22200%22 filter%3D%22url(%23n)%22/%3E%3C/svg%3E');background-size:200px;">
            </div>
        </div>

        {{-- Animated light shafts --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                style="position:absolute;top:-20%;left:15%;width:1px;height:140%;
                        background:linear-gradient(180deg,transparent,rgba(79,142,247,0.15) 30%,rgba(79,142,247,0.08) 70%,transparent);
                        transform:rotate(-8deg);animation:shaft-drift 12s ease-in-out infinite;">
            </div>
            <div
                style="position:absolute;top:-20%;left:45%;width:1px;height:140%;
                        background:linear-gradient(180deg,transparent,rgba(139,92,246,0.1) 40%,rgba(139,92,246,0.06) 70%,transparent);
                        transform:rotate(3deg);animation:shaft-drift 16s ease-in-out 4s infinite;">
            </div>
            <div
                style="position:absolute;top:-20%;right:20%;width:1px;height:140%;
                        background:linear-gradient(180deg,transparent,rgba(34,211,238,0.08) 40%,transparent);
                        transform:rotate(6deg);animation:shaft-drift 14s ease-in-out 8s infinite;">
            </div>
        </div>

        {{-- Floating orbs --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                style="position:absolute;width:600px;height:600px;border-radius:50%;
                        background:radial-gradient(circle,rgba(79,142,247,0.12) 0%,transparent 70%);
                        top:-100px;left:-200px;animation:orb-float 20s ease-in-out infinite;
                        filter:blur(40px);">
            </div>
            <div
                style="position:absolute;width:500px;height:500px;border-radius:50%;
                        background:radial-gradient(circle,rgba(139,92,246,0.1) 0%,transparent 70%);
                        bottom:-100px;right:-150px;animation:orb-float 25s ease-in-out 5s infinite reverse;
                        filter:blur(50px);">
            </div>
        </div>

        {{-- Particle field --}}
        <div class="absolute inset-0 pointer-events-none" id="particle-field">
            @php $pc = ['rgba(79,142,247','rgba(139,92,246','rgba(34,211,238']; @endphp
            @for ($i = 0; $i < 28; $i++)
                @php $c = $pc[rand(0,2)]; @endphp
                <div class="absolute rounded-full"
                    style="width:{{ rand(2, 5) }}px;height:{{ rand(2, 5) }}px;
                            left:{{ rand(3, 97) }}%;top:{{ rand(5, 95) }}%;
                            background:{{ $c }},{{ rand(5, 9) / 10 }});
                            animation:particle-drift {{ rand(8, 20) }}s linear {{ rand(0, 10) }}s infinite;
                            filter:blur({{ rand(0, 1) }}px);">
                </div>
            @endfor
        </div>

        {{-- HERO CONTENT --}}
        <div id="hero-content" class="relative z-10 w-full max-w-7xl mx-auto px-6 md:px-12"
            style="padding-top:120px;padding-bottom:160px;">

            {{-- Badge --}}
            <div id="hero-badge" style="opacity:0;transform:translateY(30px);" class="mb-8 md:mb-10 inline-flex">
                <div class="flex items-center gap-3 px-5 py-2.5 rounded-full"
                    style="background:rgba(255,255,255,0.04);
                            border:1px solid rgba(255,255,255,0.1);
                            backdrop-filter:blur(20px);">
                    <span
                        style="width:6px;height:6px;border-radius:50%;background:#34d399;
                                 box-shadow:0 0 8px rgba(52,211,153,0.8);
                                 animation:valdo-pulse 2s infinite;display:inline-block;"></span>
                    <img src="{{ asset('images/asset/logoo.png') }}" alt="" class="h-5 w-auto"
                        onerror="this.style.display='none'">
                    <span
                        style="font-size:0.68rem;font-weight:700;letter-spacing:0.2em;color:rgba(255,255,255,0.6);text-transform:uppercase;">PT
                        Valdo Outsourcing</span>
                    <span class="valdo-divider-vertical" style="height:12px;background:rgba(255,255,255,0.12);"></span>
                    <span style="font-size:0.68rem;font-weight:600;letter-spacing:0.08em;color:#34d399;">System
                        v2.0</span>
                </div>
            </div>

            {{-- Main headline --}}
            <div class="overflow-visible mb-6">
                <div class="hero-line"
                    style="opacity:0;transform:translateY(100%) skewY(3deg);transform-origin:left;display:block;">
                    <h1
                        style="font-size:clamp(3.5rem,10vw,9.5rem);font-weight:900;line-height:0.9;
                                letter-spacing:-0.05em;color:#fff;
                                text-shadow:0 0 120px rgba(79,142,247,0.3);">
                        EVALUASI PENILAIAN SYSTEM
                    </h1>
                </div>
                <div class="hero-line"
                    style="opacity:0;transform:translateY(100%) skewY(3deg);transform-origin:left;display:block;margin-top:8px;">
                    <h1
                        style="font-size:clamp(3.5rem,10vw,9.5rem);font-weight:900;line-height:0.9;
                                letter-spacing:-0.05em;
                                background:linear-gradient(100deg,var(--color-accent-blue) 0%,var(--color-accent-cyan) 40%,var(--color-accent-purple) 100%);
                                -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
                                filter:drop-shadow(0 0 40px rgba(79,142,247,0.4));">
                        PT VALDO SUMBER DAYA MANDIRI
                    </h1>
                </div>
            </div>

            {{-- Divider accent line --}}
            <div id="hero-line-accent" style="opacity:0;width:0;" class="mb-8 h-px"
                style="background:linear-gradient(90deg,var(--color-accent-blue),var(--color-accent-purple),transparent);">
            </div>

            {{-- Sub and CTA side by side on desktop --}}
            <div class="flex flex-col md:flex-row md:items-end gap-8 md:gap-16">
                <div id="hero-sub" style="opacity:0;transform:translateY(20px);" class="max-w-lg">
                    <p style="font-size:1.05rem;line-height:1.75;color:rgba(200,204,220,0.75);">
                        Sistem evaluasi karyawan berbasis <strong style="color:#000;font-weight:600;">token
                            unik</strong> —
                        transparan dan terotomasi penuh dari penempatan hingga rekomendasi kontrak. Dirancang eksklusif
                        untuk
                        <strong style="color:var(--color-accent-cyan);font-weight:600;">PT Valdo Outsourcing</strong>.
                    </p>
                </div>
                <div id="hero-ctas" style="opacity:0;transform:translateY(20px);"
                    class="flex flex-col sm:flex-row gap-3 md:flex-shrink-0">
                    <button onclick="window.location.href='{{ route('login') }}'" id="main-cta-btn"
                        class="valdo-btn valdo-btn-primary valdo-btn-lg"
                        style="border-radius:14px;padding:16px 36px;font-size:1rem;font-weight:700;
                                   box-shadow:0 0 0 1px rgba(79,142,247,0.3),var(--neu-shadow-xl),0 0 60px rgba(79,142,247,0.3);">
                        Masuk ke Sistem →
                    </button>
                    <button onclick="document.getElementById('features-section').scrollIntoView({behavior:'smooth'})"
                        class="valdo-btn valdo-btn-ghost valdo-btn-lg"
                        style="border-radius:14px;padding:16px 28px;font-size:1rem;
                                   color:rgba(200,204,220,0.7);border:1px solid rgba(255,255,255,0.08);">
                        Lihat Fitur
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Floating mini stats --}}
            <div id="hero-stats" style="opacity:0;transform:translateY(20px);" class="mt-16 flex flex-wrap gap-4">
                @foreach ([['500+', 'Karyawan Terkelola', 'var(--color-accent-blue)'], ['50+', 'Perusahaan Klien', 'var(--color-accent-purple)'], ['98%', 'Akurasi Evaluasi', 'var(--color-accent-cyan)']] as [$num, $label, $color])
                    <div
                        style="background:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);
                                backdrop-filter:blur(16px);border-radius:12px;padding:12px 20px;
                                display:flex;align-items:center;gap:12px;">
                        <span
                            style="font-size:1.35rem;font-weight:900;color:{{ $color }};letter-spacing:-0.03em;">{{ $num }}</span>
                        <span
                            style="font-size:0.78rem;color:rgba(200,204,220,0.55);font-weight:500;max-width:80px;line-height:1.3;">{{ $label }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Scroll indicator --}}
        <div id="scroll-indicator" class="absolute bottom-10 left-1/2 z-20"
            style="transform:translateX(-50%);opacity:0;animation:fade-bounce 2s ease-in-out 2s infinite;">
            <div style="display:flex;flex-direction:column;align-items:center;gap:6px;">
                <span
                    style="font-size:0.62rem;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.3);font-weight:600;">Scroll</span>
                <div
                    style="width:1px;height:40px;background:linear-gradient(180deg,rgba(79,142,247,0.6),transparent);">
                </div>
            </div>
        </div>

        {{-- Wave --}}
        <div class="absolute bottom-0 left-0 right-0 z-10 pointer-events-none" style="line-height:0;">
            <svg viewBox="0 0 1440 120" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg"
                style="display:block;width:100%;height:80px;">
                <path
                    d="M0,60 C200,120 400,20 600,70 C800,120 1000,10 1200,55 C1320,80 1400,40 1440,60 L1440,120 L0,120 Z"
                    fill="var(--color-base-100)" opacity="1" />
            </svg>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════════════════
         LAPTOP SHOWPIECE
    ═══════════════════════════════════════════════════════ --}}
    <section class="relative py-8 pb-20" style="background:var(--color-base-100);z-index:10;">
        <div class="flex justify-center px-4" style="margin-top:-60px;">
            <div id="laptop-wrapper" class="relative w-full" style="max-width:860px;">

                {{-- Glow behind laptop --}}
                <div
                    style="position:absolute;inset:-40px;border-radius:50%;
                            background:radial-gradient(ellipse at 50% 60%,rgba(79,142,247,0.2) 0%,rgba(139,92,246,0.1) 45%,transparent 70%);
                            filter:blur(60px);transform:scaleY(0.6);pointer-events:none;z-index:0;">
                </div>

                {{-- Reflection line --}}
                <div
                    style="position:absolute;bottom:-2px;left:10%;right:10%;height:1px;
                            background:linear-gradient(90deg,transparent,rgba(79,142,247,0.4),rgba(139,92,246,0.4),transparent);
                            filter:blur(2px);z-index:2;">
                </div>

                <img src="{{ asset('images/asset/gambar3.png') }}" alt="Dashboard Preview" id="laptop-img"
                    class="relative w-full h-auto object-contain z-10"
                    style="animation:valdo-float 6s ease-in-out infinite;
                            filter:drop-shadow(0 40px 80px rgba(0,0,0,0.7)) drop-shadow(0 0 60px rgba(79,142,247,0.22));"
                    onerror="this.style.display='none';document.getElementById('laptop-fallback').style.display='flex';">

                <div id="laptop-fallback"
                    class="hidden w-full rounded-3xl items-center justify-content:center relative z-10"
                    style="height:420px;background:var(--color-base-300);border:1px solid rgba(79,142,247,0.2);">
                    <div class="text-center w-full" style="padding:60px 0;">
                        <div style="font-size:4rem;">📊</div>
                        <p class="valdo-text-muted mt-3">Dashboard Preview</p>
                    </div>
                </div>

                {{-- Floating badge TL --}}
                <div class="absolute hidden md:flex items-center gap-3 z-20"
                    style="top:-18px;right:-20px;
                            background:var(--color-base-300);
                            border:1px solid rgba(79,142,247,0.25);
                            border-radius:14px;padding:10px 16px;
                            box-shadow:var(--neu-shadow-lg),0 0 20px rgba(79,142,247,0.15);
                            animation:valdo-float 4.5s ease-in-out 1s infinite;">
                    <div
                        style="width:32px;height:32px;border-radius:8px;background:rgba(52,211,153,0.15);
                                display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="#34d399" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.78rem;font-weight:700;color:#000;white-space:nowrap;">Token Terkirim</p>
                        <p style="font-size:0.65rem;color:#6b7190;">2 detik yang lalu</p>
                    </div>
                </div>

                {{-- Floating badge BR --}}
                <div class="absolute hidden md:flex items-center gap-3 z-20"
                    style="bottom:-16px;left:-16px;
                            background:var(--color-base-300);
                            border:1px solid rgba(139,92,246,0.25);
                            border-radius:14px;padding:10px 16px;
                            box-shadow:var(--neu-shadow-lg),0 0 20px rgba(139,92,246,0.15);
                            animation:valdo-float 5.5s ease-in-out 0.5s infinite;">
                    <div
                        style="width:32px;height:32px;border-radius:8px;background:rgba(139,92,246,0.15);
                                display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="var(--color-accent-purple)" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size:0.78rem;font-weight:700;color:#000;white-space:nowrap;">Lanjut Kontrak ✓
                        </p>
                        <p style="font-size:0.65rem;color:#6b7190;">Rekomendasi Otomatis</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section label --}}
        <div class="text-center mt-24 mb-4">
            <span class="valdo-text-label" style="color:var(--color-accent-blue);letter-spacing:0.18em;">PLATFORM
                TERPERCAYA</span>
        </div>
        <h2 class="valdo-heading-lg text-center px-6" style="font-size:clamp(1.8rem,4vw,3rem);">
            Satu Platform. Semua Kendali.
        </h2>
        <p class="valdo-text-muted text-center mt-3 max-w-md mx-auto px-6" style="line-height:1.75;">
            Dari input data karyawan hingga rekomendasi kontrak — semua terotomasi, transparan, dan dapat diaudit kapan
            saja.
        </p>
    </section>


    {{-- ═══════════════════════════════════════════════════════
         FEATURES — Asymmetric Zig-Zag
    ═══════════════════════════════════════════════════════ --}}
    <section id="features-section" class="relative py-32 px-6 overflow-hidden"
        style="background:var(--color-base-100);">

        {{-- Decorative lines background --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <svg class="absolute" style="width:100%;height:100%;top:0;left:0;opacity:0.03;" viewBox="0 0 1440 1200"
                preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
                <line x1="0" y1="200" x2="1440" y2="800" stroke="white"
                    stroke-width="1" />
                <line x1="0" y1="500" x2="1440" y2="100" stroke="white"
                    stroke-width="1" />
                <line x1="0" y1="900" x2="1440" y2="400" stroke="white"
                    stroke-width="1" />
                <circle cx="720" cy="600" r="400" stroke="white" stroke-width="1" fill="none" />
            </svg>
            <div
                style="position:absolute;width:800px;height:800px;border-radius:50%;
                        left:-300px;top:50%;transform:translateY(-50%);
                        background:radial-gradient(circle,rgba(79,142,247,0.04) 0%,transparent 70%);">
            </div>
            <div
                style="position:absolute;width:600px;height:600px;border-radius:50%;
                        right:-200px;top:20%;
                        background:radial-gradient(circle,rgba(139,92,246,0.04) 0%,transparent 70%);">
            </div>
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            <div class="text-center mb-24">
                <span class="valdo-text-label" style="color:var(--color-accent-purple);letter-spacing:0.18em;">FITUR
                    UNGGULAN</span>
                <h2
                    style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;letter-spacing:-0.04em;color:#000;margin-top:10px;line-height:1.1;">
                    Dirancang untuk<br />
                    <span
                        style="background:linear-gradient(135deg,var(--color-accent-blue),var(--color-accent-purple));
                                 -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">
                        Efisiensi Nyata.
                    </span>
                </h2>
            </div>

            {{-- ── FEATURE 1: Magic Link ── --}}
            <div class="feature-blob flex flex-col lg:flex-row items-center gap-16 mb-32" data-dir="left">
                <div class="flex-1 order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full"
                        style="background:rgba(79,142,247,0.08);border:1px solid rgba(79,142,247,0.18);">
                        <span
                            style="width:6px;height:6px;border-radius:50%;background:var(--color-accent-blue);animation:valdo-pulse 2s infinite;display:inline-block;"></span>
                        <span class="valdo-text-label" style="color:var(--color-accent-blue);">EVALUASI TANPA
                            LOGIN</span>
                    </div>
                    <h3
                        style="font-size:clamp(2rem,4vw,3.5rem);font-weight:900;letter-spacing:-0.04em;line-height:1;color:#000;margin-bottom:20px;">
                        Magic Link<br />Evaluation
                    </h3>
                    <p style="color:#000;font-size:1rem;line-height:1.8;margin-bottom:24px;max-width:440px;">
                        Sistem generate token unik yang dikirim langsung ke HRD klien via email. Klik link, isi form
                        evaluasi, selesai — tanpa perlu buat akun atau login. Token otomatis hangus setelah dipakai.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="valdo-badge valdo-badge-blue">Token Unik</span>
                        <span class="valdo-badge valdo-badge-cyan">Auto-expire</span>
                        <span class="valdo-badge valdo-badge-muted">One-time Use</span>
                        <span class="valdo-badge valdo-badge-muted">Zero Friction</span>
                    </div>
                </div>

                <div class="flex-1 order-1 lg:order-2 w-full">
                    <div class="relative p-8 overflow-hidden"
                        style="background:linear-gradient(135deg,var(--color-base-300) 0%,var(--color-base-200) 100%);
                                border-radius:2.5rem 0.8rem 2.5rem 0.8rem;
                                border:1px solid rgba(79,142,247,0.12);
                                box-shadow:var(--neu-shadow-xl),0 0 60px rgba(79,142,247,0.06);">

                        {{-- Corner glow --}}
                        <div
                            style="position:absolute;top:0;right:0;width:180px;height:180px;border-radius:50%;
                                    background:radial-gradient(circle,rgba(79,142,247,0.12) 0%,transparent 70%);
                                    transform:translate(30%,-30%);pointer-events:none;">
                        </div>

                        {{-- Step list --}}
                        <div style="display:flex;flex-direction:column;gap:10px;position:relative;z-index:1;">
                            @foreach ([['01', 'Admin buat jadwal evaluasi bulanan', 'var(--color-accent-blue)'], ['02', 'Sistem generate & kirim token ke HRD klien', 'var(--color-accent-cyan)'], ['03', 'HRD klik magic link, isi skor per kriteria', 'var(--color-accent-purple)'], ['04', 'Token hangus setelah submit, nilai masuk pending', '#34d399']] as [$n, $t, $c])
                                <div style="display:flex;align-items:center;gap:14px;
                                            background:rgba(255,255,255,0.03);
                                            border:1px solid rgba(255,255,255,0.05);
                                            border-radius:14px;padding:14px 16px;
                                            transition:all 0.2s ease;"
                                    x-on:mouseenter="$el.style.background='rgba(79,142,247,0.05)';$el.style.borderColor='rgba(79,142,247,0.12)'"
                                    x-on:mouseleave="$el.style.background='rgba(255,255,255,0.03)';$el.style.borderColor='rgba(255,255,255,0.05)'">
                                    <div
                                        style="width:28px;height:28px;border-radius:8px;flex-shrink:0;
                                                background:rgba(255,255,255,0.04);
                                                display:flex;align-items:center;justify-content:center;">
                                        <span
                                            style="font-family:var(--font-mono);font-size:0.65rem;color:rgba(255,255,255,0.25);font-weight:700;">{{ $n }}</span>
                                    </div>
                                    <p style="font-size:0.875rem;font-weight:500;color:#c8ccdc;flex:1;">
                                        {{ $t }}</p>
                                    <div
                                        style="width:7px;height:7px;border-radius:50%;background:{{ $c }};
                                                flex-shrink:0;box-shadow:0 0 8px {{ $c }};">
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Email preview mockup --}}
                        <div
                            style="margin-top:16px;background:rgba(255,255,255,0.03);border-radius:14px;
                                    padding:14px 16px;border:1px solid rgba(255,255,255,0.05);position:relative;z-index:1;">
                            <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                                <div style="display:flex;gap:4px;">
                                    @foreach (['#f87171', '#f59e0b', '#34d399'] as $dot)
                                        <div
                                            style="width:7px;height:7px;border-radius:50%;background:{{ $dot }};opacity:0.6;">
                                        </div>
                                    @endforeach
                                </div>
                                <span
                                    style="font-size:0.65rem;color:#3d4263;font-family:var(--font-mono);">evaluasi@ptva
                                    ldo.co.id</span>
                            </div>
                            <p style="font-size:0.72rem;color:#6b7190;line-height:1.5;">
                                <span style="color:#4f8ef7;">📧</span> <strong style="color:#8892b0;">Formulir
                                    Evaluasi — Agustus 2024</strong><br>
                                Yth. HRD PT Maju Bersama, klik link berikut untuk mengisi...<br>
                                <span
                                    style="color:var(--color-accent-cyan);font-family:var(--font-mono);font-size:0.65rem;">🔗
                                    eval.valdo.app/m/a8f3k2...</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── FEATURE 2: Dashboard Admin ── --}}
            <div class="feature-blob flex flex-col lg:flex-row-reverse items-center gap-16 mb-32" data-dir="right">
                <div class="flex-1">
                    <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full"
                        style="background:rgba(139,92,246,0.08);border:1px solid rgba(139,92,246,0.18);">
                        <span
                            style="width:6px;height:6px;border-radius:50%;background:var(--color-accent-purple);animation:valdo-pulse 2s infinite;display:inline-block;"></span>
                        <span class="valdo-text-label" style="color:var(--color-accent-purple);">MONITORING
                            TERPUSAT</span>
                    </div>
                    <h3
                        style="font-size:clamp(2rem,4vw,3.5rem);font-weight:900;letter-spacing:-0.04em;line-height:1;color:#000;margin-bottom:20px;">
                        Dashboard<br />Admin Penuh
                    </h3>
                    <p
                        style="color:#000200,204,220,0.65);font-size:1rem;line-height:1.8;margin-bottom:24px;max-width:440px;">
                        Admin PT Valdo punya kendali penuh — pantau status evaluasi seluruh karyawan, verifikasi nilai
                        yang masuk, dan lacak semua aktivitas melalui log otomatis yang terekam lengkap.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="valdo-badge valdo-badge-purple">Verifikasi Nilai</span>
                        <span class="valdo-badge valdo-badge-pink">Log Aktivitas</span>
                        <span class="valdo-badge valdo-badge-muted">Multi-Klien</span>
                        <span class="valdo-badge valdo-badge-muted">Real-time</span>
                    </div>
                </div>

                <div class="flex-1 w-full">
                    <div class="relative p-8 overflow-hidden"
                        style="background:linear-gradient(135deg,var(--color-base-300) 0%,var(--color-base-200) 100%);
                                border-radius:0.8rem 2.5rem 0.8rem 2.5rem;
                                border:1px solid rgba(139,92,246,0.12);
                                box-shadow:var(--neu-shadow-xl),0 0 60px rgba(139,92,246,0.06);">

                        <div
                            style="position:absolute;bottom:0;left:0;width:200px;height:200px;border-radius:50%;
                                    background:radial-gradient(circle,rgba(139,92,246,0.1) 0%,transparent 70%);
                                    transform:translate(-30%,30%);pointer-events:none;">
                        </div>

                        {{-- Live stats grid --}}
                        <div class="grid grid-cols-2 gap-3 relative z-10 mb-4">
                            @foreach ([['Karyawan Aktif', '247', '↑ 12%', 'var(--color-accent-blue)'], ['Evaluasi Bulan Ini', '89', '↑ 8%', 'var(--color-accent-purple)'], ['Pending Verifikasi', '14', '→ Cek', '#f59e0b'], ['Rata-rata Nilai', '87.4', '↑ 3pt', '#34d399']] as [$l, $v, $t, $c])
                                <div
                                    style="background:rgba(255,255,255,0.03);border:1px solid rgba(255,255,255,0.05);
                                            border-radius:14px;padding:16px;">
                                    <p
                                        style="font-size:0.7rem;color:#6b7190;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.06em;">
                                        {{ $l }}</p>
                                    <p
                                        style="font-size:1.6rem;font-weight:900;color:#000;letter-spacing:-0.04em;line-height:1;">
                                        {{ $v }}</p>
                                    <span
                                        style="font-size:0.72rem;font-weight:600;color:{{ $c }};margin-top:4px;display:block;">{{ $t }}</span>
                                </div>
                            @endforeach
                        </div>

                        {{-- Activity feed --}}
                        <div
                            style="background:rgba(255,255,255,0.02);border-radius:12px;padding:12px;
                                    border:1px solid rgba(255,255,255,0.04);position:relative;z-index:1;">
                            <p
                                style="font-size:0.65rem;color:#3d4263;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:8px;">
                                Log Aktivitas Terbaru</p>
                            @foreach ([['verified', 'Evaluasi Budi S. disetujui', '2m lalu'], ['sent', 'Token terkirim ke PT Maju', '15m lalu'], ['create', 'Karyawan baru ditambahkan', '1j lalu']] as [$type, $msg, $time])
                                <div
                                    style="display:flex;align-items:center;gap:8px;padding:6px 0;border-bottom:1px solid rgba(255,255,255,0.03);">
                                    <div
                                        style="width:6px;height:6px;border-radius:50%;flex-shrink:0;
                                                background:{{ $type === 'verified' ? '#34d399' : ($type === 'sent' ? 'var(--color-accent-blue)' : 'var(--color-accent-purple)') }};">
                                    </div>
                                    <span style="font-size:0.75rem;color:#8892b0;flex:1;">{{ $msg }}</span>
                                    <span style="font-size:0.65rem;color:#3d4263;">{{ $time }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── FEATURE 3: Kalkulasi Otomatis ── --}}
            <div class="feature-blob flex flex-col lg:flex-row items-center gap-16" data-dir="left">
                <div class="flex-1 order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 mb-6 px-4 py-2 rounded-full"
                        style="background:rgba(34,211,238,0.08);border:1px solid rgba(34,211,238,0.18);">
                        <span
                            style="width:6px;height:6px;border-radius:50%;background:var(--color-accent-cyan);animation:valdo-pulse 2s infinite;display:inline-block;"></span>
                        <span class="valdo-text-label" style="color:var(--color-accent-cyan);">REKOMENDASI
                            OTOMATIS</span>
                    </div>
                    <h3
                        style="font-size:clamp(2rem,4vw,3.5rem);font-weight:900;letter-spacing:-0.04em;line-height:1;color:#000;margin-bottom:20px;">
                        Kalkulasi Nilai<br />& Rekomendasi
                    </h3>
                    <p
                        style="color:#000200,204,220,0.65);font-size:1rem;line-height:1.8;margin-bottom:24px;max-width:440px;">
                        Sistem otomatis menghitung rata-rata tertimbang seluruh evaluasi bulanan yang sudah
                        diverifikasi. Hasilnya langsung menghasilkan rekomendasi "Lanjut" atau "Putus Kontrak" yang bisa
                        diekspor sebagai laporan resmi.
                    </p>
                    <div class="flex flex-wrap gap-2">
                        <span class="valdo-badge valdo-badge-cyan">Weighted Score</span>
                        <span class="valdo-badge valdo-badge-green">Export Laporan</span>
                        <span class="valdo-badge valdo-badge-muted">Transparan</span>
                        <span class="valdo-badge valdo-badge-muted">Audit-ready</span>
                    </div>
                </div>

                <div class="flex-1 order-1 lg:order-2 w-full">
                    <div class="relative p-8 overflow-hidden"
                        style="background:linear-gradient(135deg,var(--color-base-300) 0%,var(--color-base-200) 100%);
                                border-radius:2.5rem 0.8rem 2.5rem 0.8rem;
                                border:1px solid rgba(34,211,238,0.12);
                                box-shadow:var(--neu-shadow-xl),0 0 60px rgba(34,211,238,0.05);">

                        <div
                            style="position:absolute;top:0;left:0;width:150px;height:150px;border-radius:50%;
                                    background:radial-gradient(circle,rgba(34,211,238,0.08) 0%,transparent 70%);
                                    transform:translate(-30%,-30%);pointer-events:none;">
                        </div>

                        <p
                            style="font-size:0.65rem;color:#3d4263;text-transform:uppercase;letter-spacing:0.1em;margin-bottom:16px;font-family:var(--font-mono);">
                            EVALUASI — Budi Santoso · Sep 2024
                        </p>

                        <div
                            style="display:flex;flex-direction:column;gap:12px;margin-bottom:20px;position:relative;z-index:1;">
                            @foreach ([['Kedisiplinan', '30%', 90, 'var(--color-accent-blue)'], ['Target Kerja', '40%', 85, 'var(--color-accent-purple)'], ['Attitude & Soft Skill', '30%', 92, 'var(--color-accent-cyan)']] as [$k, $w, $v, $c])
                                <div>
                                    <div
                                        style="display:flex;align-items:center;justify-content:space-between;margin-bottom:6px;">
                                        <div style="display:flex;align-items:center;gap:8px;">
                                            <span
                                                style="font-size:0.82rem;font-weight:600;color:#c8ccdc;">{{ $k }}</span>
                                            <span
                                                style="font-size:0.65rem;background:rgba(255,255,255,0.05);border:1px solid rgba(255,255,255,0.08);border-radius:4px;padding:1px 6px;color:#6b7190;">bobot
                                                {{ $w }}</span>
                                        </div>
                                        <span
                                            style="font-size:0.95rem;font-weight:800;color:{{ $c }};font-family:var(--font-mono);">{{ $v }}</span>
                                    </div>
                                    <div
                                        style="height:6px;background:var(--color-base-200);border-radius:99px;overflow:hidden;box-shadow:var(--neu-inset);">
                                        <div
                                            style="height:100%;width:{{ $v }}%;border-radius:99px;
                                                    background:linear-gradient(90deg,{{ $c }},{{ $c }}88);
                                                    box-shadow:0 0 8px {{ $c }};">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div
                            style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.06),transparent);margin-bottom:16px;">
                        </div>

                        <div
                            style="display:flex;align-items:center;justify-content:space-between;
                                    background:linear-gradient(135deg,rgba(52,211,153,0.08),rgba(52,211,153,0.04));
                                    border:1px solid rgba(52,211,153,0.2);border-radius:16px;padding:18px 20px;
                                    position:relative;z-index:1;">
                            <div>
                                <p
                                    style="font-size:0.7rem;color:#6b7190;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">
                                    Rekomendasi Sistem</p>
                                <p style="font-size:1.1rem;font-weight:900;color:#34d399;letter-spacing:-0.02em;">
                                    LANJUT KONTRAK ✓</p>
                            </div>
                            <div style="text-align:right;">
                                <p
                                    style="font-size:0.7rem;color:#6b7190;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:4px;">
                                    Nilai Akhir</p>
                                <p
                                    style="font-size:2.5rem;font-weight:900;color:#34d399;letter-spacing:-0.05em;line-height:1;">
                                    88.5</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════════════════
         STATS MARQUEE STRIP
    ═══════════════════════════════════════════════════════ --}}
    <div
        style="background:var(--color-base-200);
                border-top:1px solid rgba(255,255,255,0.04);
                border-bottom:1px solid rgba(255,255,255,0.04);
                padding:0;overflow:hidden;position:relative;">

        {{-- Fade edges --}}
        <div
            style="position:absolute;left:0;top:0;bottom:0;width:120px;z-index:2;
                    background:linear-gradient(90deg,var(--color-base-200),transparent);pointer-events:none;">
        </div>
        <div
            style="position:absolute;right:0;top:0;bottom:0;width:120px;z-index:2;
                    background:linear-gradient(270deg,var(--color-base-200),transparent);pointer-events:none;">
        </div>

        <div class="marquee-track"
            style="display:flex;gap:0;white-space:nowrap;animation:marquee-scroll 25s linear infinite;width:max-content;">
            @php
                $items = [
                    ['500+', 'Karyawan Terkelola'],
                    ['50+', 'Klien Aktif'],
                    ['98%', 'Akurasi Evaluasi'],
                    ['100%', 'Paperless'],
                    ['24/7', 'Sistem Berjalan'],
                    ['0', 'Downtime'],
                    ['500+', 'Karyawan Terkelola'],
                    ['50+', 'Klien Aktif'],
                    ['98%', 'Akurasi Evaluasi'],
                    ['100%', 'Paperless'],
                    ['24/7', 'Sistem Berjalan'],
                    ['0', 'Downtime'],
                ];
            @endphp
            @foreach ($items as $i => [$num, $label])
                <div style="display:inline-flex;align-items:center;gap:32px;padding:28px 40px;">
                    <div style="display:flex;align-items:baseline;gap:10px;">
                        <span
                            style="font-size:2rem;font-weight:900;letter-spacing:-0.05em;
                                     background:linear-gradient(135deg,{{ ['var(--color-accent-blue)', 'var(--color-accent-purple)', 'var(--color-accent-cyan)', '#34d399'][$i % 4] }},{{ ['var(--color-accent-cyan)', 'var(--color-accent-pink)', 'var(--color-accent-blue)', 'var(--color-accent-blue)'][$i % 4] }});
                                     -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $num }}</span>
                        <span
                            style="font-size:0.78rem;color:#6b7190;font-weight:500;text-transform:uppercase;letter-spacing:0.06em;">{{ $label }}</span>
                    </div>
                    <span
                        style="width:4px;height:4px;border-radius:50%;background:rgba(255,255,255,0.1);display:inline-block;"></span>
                </div>
            @endforeach
        </div>
    </div>


    {{-- ═══════════════════════════════════════════════════════
         CTA — Cinematic Full Section
    ═══════════════════════════════════════════════════════ --}}
    <section id="cta-section" class="relative overflow-hidden"
        style="background:var(--color-base-50);padding:140px 24px;">

        {{-- Layered background --}}
        <div class="absolute inset-0 pointer-events-none">
            <div
                style="position:absolute;inset:0;
                        background:radial-gradient(ellipse 100% 80% at 50% 50%,rgba(79,142,247,0.07) 0%,rgba(139,92,246,0.05) 40%,transparent 70%);">
            </div>
            <div
                style="position:absolute;top:0;left:0;right:0;height:1px;
                        background:linear-gradient(90deg,transparent,rgba(79,142,247,0.3),rgba(139,92,246,0.3),transparent);">
            </div>
            <div
                style="position:absolute;bottom:0;left:0;right:0;height:1px;
                        background:linear-gradient(90deg,transparent,rgba(79,142,247,0.2),transparent);">
            </div>

            {{-- Grid lines --}}
            <div
                style="position:absolute;inset:0;opacity:0.03;
                        background-image:linear-gradient(rgba(255,255,255,0.5) 1px,transparent 1px),
                                         linear-gradient(90deg,rgba(255,255,255,0.5) 1px,transparent 1px);
                        background-size:80px 80px;">
            </div>

            {{-- Big glows --}}
            <div
                style="position:absolute;width:900px;height:900px;border-radius:50%;
                        left:50%;top:50%;transform:translate(-50%,-50%);
                        background:radial-gradient(circle,rgba(79,142,247,0.06) 0%,transparent 65%);
                        animation:orb-float 15s ease-in-out infinite;filter:blur(20px);">
            </div>
        </div>

        {{-- Wave top --}}
        <div class="absolute top-0 left-0 right-0 pointer-events-none" style="line-height:0;">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="display:block;width:100%;height:60px;">
                <path d="M0,40 C360,80 720,0 1080,40 C1260,60 1380,20 1440,40 L1440,80 L0,80 Z"
                    fill="var(--color-base-100)" />
            </svg>
        </div>

        <div class="relative z-10 text-center max-w-4xl mx-auto">
            <span class="valdo-text-label" style="color:var(--color-accent-cyan);letter-spacing:0.2em;">SUDAH
                SIAP?</span>

            <h2
                style="font-size:clamp(2.5rem,9vw,8rem);font-weight:900;letter-spacing:-0.05em;
                        line-height:0.9;color:#000;margin-top:20px;margin-bottom:0;">
                MULAI<br />
                <span
                    style="background:linear-gradient(100deg,var(--color-accent-blue) 0%,var(--color-accent-cyan) 45%,var(--color-accent-purple) 100%);
                             -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
                             filter:drop-shadow(0 0 60px rgba(79,142,247,0.4));">
                    KELOLA.
                </span>
            </h2>

            <p style="color:#000;font-size:1rem;line-height:1.7;margin:32px auto 0;max-width:400px;">
                Masuk ke dashboard admin dan kelola karyawan, klien, dan evaluasi dalam satu sistem terintegrasi dan
                aman.
            </p>

            {{-- Magnetic CTA --}}
            <div class="mt-16 flex flex-col items-center gap-5">
                <div id="magnetic-area" class="relative inline-block" @mousemove="onMagnetMove($event)"
                    @mouseleave="onMagnetLeave()">

                    {{-- Animated rings --}}
                    <div
                        style="position:absolute;inset:-12px;border-radius:999px;
                                border:1px solid rgba(79,142,247,0.15);
                                animation:ring-pulse 2.5s ease-out infinite;pointer-events:none;">
                    </div>
                    <div
                        style="position:absolute;inset:-24px;border-radius:999px;
                                border:1px solid rgba(79,142,247,0.08);
                                animation:ring-pulse 2.5s ease-out 0.8s infinite;pointer-events:none;">
                    </div>

                    <button id="magnetic-btn" onclick="window.location.href='{{ route('login') }}'"
                        class="valdo-btn valdo-btn-primary relative overflow-hidden"
                        style="border-radius:999px;padding:22px 64px;font-size:1.1rem;font-weight:800;
                                   letter-spacing:-0.02em;will-change:transform;
                                   box-shadow:0 0 0 1px rgba(79,142,247,0.25),
                                              var(--neu-shadow-xl),
                                              0 0 80px rgba(79,142,247,0.3),
                                              0 0 160px rgba(79,142,247,0.1);">
                        Masuk ke Sistem →
                    </button>
                </div>

                <p style="font-size:0.72rem;color:rgba(107,113,144,0.6);letter-spacing:0.04em;">
                    Sistem manajemen eksklusif PT Valdo · Authorized access only
                </p>
            </div>
        </div>

        {{-- Wave bottom --}}
        <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="line-height:0;">
            <svg viewBox="0 0 1440 80" preserveAspectRatio="none" style="display:block;width:100%;height:60px;">
                <path d="M0,40 C360,0 720,80 1080,40 C1260,20 1380,60 1440,40 L1440,80 L0,80 Z"
                    fill="var(--color-base-100)" />
            </svg>
        </div>
    </section>


    {{-- ═══════════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════════ --}}
    <footer style="background:var(--color-base-100);padding:40px 24px 32px;">
        <div
            style="max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;align-items:center;
                    justify-content:space-between;gap:16px;">
            <div style="display:flex;align-items:center;gap:12px;">
                <img src="{{ asset('images/asset/logoo.png') }}" alt="Valdo"
                    style="height:28px;width:auto;opacity:0.5;" onerror="this.style.display='none'">
                <div>
                    <p style="font-size:0.8rem;font-weight:700;color:rgba(255,255,255,0.4);">PT Valdo Outsourcing</p>
                    <p style="font-size:0.68rem;color:rgba(107,113,144,0.5);">Sistem Manajemen Karyawan Outsourcing</p>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:6px;">
                <div
                    style="width:6px;height:6px;border-radius:50%;background:#34d399;box-shadow:0 0 8px rgba(52,211,153,0.6);animation:valdo-pulse 2s infinite;">
                </div>
                <span style="font-size:0.72rem;color:rgba(107,113,144,0.5);">System Online · © {{ date('Y') }} PT
                    Valdo</span>
            </div>
        </div>
    </footer>

</div>

@push('styles')
    <style>
        /* ── Custom Keyframes ───────────────────────────── */
        @keyframes shaft-drift {

            0%,
            100% {
                opacity: 0.6;
                transform: rotate(-8deg) translateX(0);
            }

            50% {
                opacity: 0.2;
                transform: rotate(-8deg) translateX(20px);
            }
        }

        @keyframes orb-float {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
            }

            33% {
                transform: translate(-48%, -53%) scale(1.05);
            }

            66% {
                transform: translate(-52%, -47%) scale(0.97);
            }
        }

        @keyframes particle-drift {
            0% {
                transform: translateY(0) translateX(0);
                opacity: 0.6;
            }

            33% {
                opacity: 0.3;
            }

            66% {
                opacity: 0.8;
            }

            100% {
                transform: translateY(-120vh) translateX(30px);
                opacity: 0;
            }
        }

        @keyframes fade-bounce {

            0%,
            100% {
                opacity: 0.4;
                transform: translateX(-50%) translateY(0);
            }

            50% {
                opacity: 0.9;
                transform: translateX(-50%) translateY(6px);
            }
        }

        @keyframes ring-pulse {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(1.5);
                opacity: 0;
            }
        }

        @keyframes marquee-scroll {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }

        .feature-blob {
            opacity: 0;
        }

        .marquee-track:hover {
            animation-play-state: paused;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js" defer></script>
    <script>
        function homeCtrl() {
            return {
                init() {
                    // Cursor glow
                    const glow = document.getElementById('cursor-glow');
                    if (glow && window.matchMedia('(pointer:fine)').matches) {
                        glow.style.opacity = '1';
                        window.addEventListener('mousemove', e => {
                            glow.style.transform = `translate(${e.clientX}px,${e.clientY}px)`;
                        }, {
                            passive: true
                        });
                    }

                    const boot = () => {
                        if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
                            return setTimeout(boot, 50);
                        }
                        gsap.registerPlugin(ScrollTrigger);
                        this.heroEntrance();
                        this.parallax();
                        this.featureBlobs();
                        this.scrollIndicator();
                    };
                    boot();
                },

                heroEntrance() {
                    const tl = gsap.timeline({
                        delay: 0.1
                    });

                    tl.to('#hero-badge', {
                        opacity: 1,
                        y: 0,
                        duration: 0.7,
                        ease: 'power3.out'
                    });

                    tl.to('.hero-line', {
                        y: '0%',
                        skewY: 0,
                        opacity: 1,
                        duration: 1.0,
                        stagger: 0.12,
                        ease: 'expo.out'
                    }, '-=0.4');

                    tl.to('#hero-line-accent', {
                        opacity: 1,
                        width: '180px',
                        duration: 0.7,
                        ease: 'power3.out'
                    }, '-=0.5');

                    tl.to('#hero-sub', {
                        opacity: 1,
                        y: 0,
                        duration: 0.6,
                        ease: 'power2.out'
                    }, '-=0.45');

                    tl.to('#hero-ctas', {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        ease: 'power2.out'
                    }, '-=0.4');

                    tl.to('#hero-stats', {
                        opacity: 1,
                        y: 0,
                        duration: 0.5,
                        ease: 'power2.out'
                    }, '-=0.35');

                    tl.to('#scroll-indicator', {
                        opacity: 1,
                        duration: 0.5
                    }, '-=0.1');
                },

                parallax() {
                    // Photo parallax
                    gsap.to('#hero-bg-img', {
                        y: 60,
                        scale: 1.0,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: '#hero',
                            start: 'top top',
                            end: 'bottom top',
                            scrub: 1.5,
                        }
                    });

                    // Content fade out
                    gsap.to('#hero-content', {
                        y: -80,
                        opacity: 0,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: '#hero',
                            start: 'top top',
                            end: '60% top',
                            scrub: true,
                        }
                    });

                    // Laptop float parallax
                    gsap.to('#laptop-wrapper', {
                        y: -40,
                        ease: 'none',
                        scrollTrigger: {
                            trigger: '#laptop-wrapper',
                            start: 'top bottom',
                            end: 'bottom top',
                            scrub: 2,
                        }
                    });
                },

                featureBlobs() {
                    document.querySelectorAll('.feature-blob').forEach(el => {
                        const isLeft = el.dataset.dir === 'left';
                        gsap.fromTo(el, {
                            opacity: 0,
                            x: isLeft ? -60 : 60,
                            y: 20
                        }, {
                            opacity: 1,
                            x: 0,
                            y: 0,
                            duration: 1.0,
                            ease: 'power3.out',
                            scrollTrigger: {
                                trigger: el,
                                start: 'top 82%',
                                toggleActions: 'play none none none',
                            }
                        });
                    });
                },

                scrollIndicator() {
                    ScrollTrigger.create({
                        trigger: '#hero',
                        start: 'top top',
                        end: '20% top',
                        onLeave: () => gsap.to('#scroll-indicator', {
                            opacity: 0,
                            duration: 0.3
                        }),
                        onEnterBack: () => gsap.to('#scroll-indicator', {
                            opacity: 1,
                            duration: 0.3
                        }),
                    });
                },

                onMagnetMove(e) {
                    const btn = document.getElementById('magnetic-btn');
                    if (!btn) return;
                    const rect = btn.getBoundingClientRect();
                    const dx = e.clientX - (rect.left + rect.width / 2);
                    const dy = e.clientY - (rect.top + rect.height / 2);
                    gsap.to(btn, {
                        x: dx * 0.28,
                        y: dy * 0.28,
                        duration: 0.4,
                        ease: 'power2.out'
                    });
                },

                onMagnetLeave() {
                    gsap.to('#magnetic-btn', {
                        x: 0,
                        y: 0,
                        duration: 0.65,
                        ease: 'elastic.out(1, 0.45)'
                    });
                },
            };
        }
    </script>
@endpush
