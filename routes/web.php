<?php

use App\Livewire\Auth\Login;
use App\Livewire\Home;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::middleware('guest')->group(function () {
    Route::get('/auth/login', Login::class)->name('login');
});

require base_path('routes/global/admin.php');
require base_path('routes/global/manajemen.php');
