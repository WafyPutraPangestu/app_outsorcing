<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles
    @stack('styles')
</head>

<body>
    @livewire('components.navbar')

    <main id="valdo-main" class="valdo-main" style="transition: margin-left var(--transition-normal);">
        {{ $slot }}
    </main>

    @livewireScripts
    @stack('scripts')
    <script>
        // Sync main margin dengan state sidebar Alpine
        document.addEventListener('alpine:initialized', () => {
            const sidebar = document.querySelector('.valdo-sidebar');
            const main = document.getElementById('valdo-main');
            if (!sidebar || !main) return;

            const observer = new MutationObserver(() => {
                const isCollapsed = sidebar.classList.contains('collapsed');
                const isMobileOpen = sidebar.classList.contains('mobile-open');
                const isDesktop = window.innerWidth >= 1024;

                if (isDesktop) {
                    main.style.marginLeft = isCollapsed ? '72px' : '260px';
                } else {
                    main.style.marginLeft = '0px';
                }
            });

            observer.observe(sidebar, {
                attributes: true,
                attributeFilter: ['class']
            });

            // Set initial
            const isDesktop = window.innerWidth >= 1024;
            main.style.marginLeft = isDesktop ? '260px' : '0px';

            window.addEventListener('resize', () => {
                const desktop = window.innerWidth >= 1024;
                const isCollapsed = sidebar.classList.contains('collapsed');
                main.style.marginLeft = desktop ? (isCollapsed ? '72px' : '260px') : '0px';
            });
        });
    </script>
</body>

</html>
