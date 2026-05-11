<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'manajemen'])->group(function () {
  Route::get('/manajemen/dashboard', App\Livewire\Manajemen\Dashboard::class)->name('manajemen.dashboard');
  Route::get('/manajemen/verifikasi', App\Livewire\Manajemen\Verifikasi::class)->name('manajemen.verifikasi');
});
