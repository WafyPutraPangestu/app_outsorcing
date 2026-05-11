<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', Login::class)->name('login');
});
// Rute Publik untuk Klien mengisi Evaluasi via Magic Link
// (Nanti kita akan buat komponen Livewire 'IsiEvaluasi' di tahap selanjutnya)
Route::get('/evaluasi/form/{token}', \App\Livewire\Klien\IsiEvaluasi::class)->name('klien.evaluasi');

require base_path('routes/global/admin.php');
require base_path('routes/global/manajemen.php');
