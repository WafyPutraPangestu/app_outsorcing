<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'manajemen'])->group(function () {
  Route::get('/manajemen/dashboard', App\Livewire\Manajemen\Dashboard::class)->name('manajemen.dashboard');
  Route::get('/manajemen/monitor-evaluasi', App\Livewire\Manajemen\MonitorEvaluasi::class)->name('manajemen.monitor-evaluasi');
  Route::get('/manajemen/log-aktivitas', App\Livewire\Manajemen\LogAktifitas::class)->name('manajemen.log-aktivitas');
});
