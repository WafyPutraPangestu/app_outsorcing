<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Evaluasi Karyawan - PT Valdo' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-base-100 min-h-screen flex items-center justify-center p-4">
    <!-- Slot ini adalah tempat dimana form evaluasi akan dirender -->
    <div class="w-full max-w-4xl">
        {{ $slot }}
    </div>

    @livewireScripts
</body>

</html>
