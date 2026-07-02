<?php

use App\Livewire\Admin\Evaluasi\Index;
use App\Livewire\Auth\Login;
use App\Livewire\Home;
use App\Livewire\Klien\IsiEvaluasi;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/auth/login', Login::class)->name('login');
});

Route::get('/evaluasi/form/{token}', IsiEvaluasi::class)
    ->name('klien.evaluasi');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', Profile::class)->name('profil');
});

require base_path('routes/global/admin.php');
require base_path('routes/global/manajemen.php');
