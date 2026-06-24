<?php

use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\Karyawan\Index as KaryawanIndex;
use App\Livewire\Admin\Karyawan\Create as KaryawanCreate;
use App\Livewire\Admin\Karyawan\Edit as KaryawanEdit;
use App\Livewire\Admin\Karyawan\Show as KaryawanShow;
use App\Livewire\Admin\Klien\Index as KlienIndex;
use App\Livewire\Admin\Klien\create as KlienCreate;
use App\Livewire\Admin\Klien\show as KlienShow;
use App\Livewire\Admin\Klien\edit as KlienEdit;
use App\Livewire\Admin\Kriteria\edit as KriteriaEdit;
use App\Livewire\Admin\Kriteria\index as KriteriaIndex;
use App\Livewire\Admin\Kriteria\create as KriteriaCreate;
use App\Livewire\Admin\Kriteria\Show as KriteriaShow;
use App\Livewire\Admin\Penempatan\edit as PenempatanEdit;
use App\Livewire\Admin\Penempatan\index as PenempatanIndex;
use App\Livewire\Admin\Penempatan\create as PenempatanCreate;
use App\Livewire\Admin\Penempatan\Show as PenempatanShow;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
  Route::get('/admin/dashboard', Dashboard::class)->name('admin.dashboard');
  Route::prefix('admin/karyawan')->name('admin.karyawan.')->group(function () {
    Route::get('/', KaryawanIndex::class)->name('index');          // Daftar Karyawan
    Route::get('/create', KaryawanCreate::class)->name('create');   // Form Tambah
    Route::get('/{karyawan}/edit', KaryawanEdit::class)->name('edit'); // Form Edit
    Route::get('/{id_karyawan}', KaryawanShow::class)->name('show');   // Detail Karyawan
  });

  Route::prefix('admin/klien')->name('admin.klien.')->group(function () {
    Route::get('/', KlienIndex::class)->name('index');
    Route::get('/create', KlienCreate::class)->name('create');
    Route::get('/{klien}/edit', KlienEdit::class)->name('edit');
    Route::get('/{id_klien}', KlienShow::class)->name('show');
  });

  Route::prefix('admin/kriteria')->name('admin.kriteria.')->group(function () {
    Route::get('/', KriteriaIndex::class)->name('index');
    Route::get('/create', KriteriaCreate::class)->name('create');
    Route::get('/{kriteria}/edit', KriteriaEdit::class)->name('edit');
    Route::get('/{id_kriteria}', KriteriaShow::class)->name('show');
  });

  Route::prefix('admin/penempatan')->name('admin.penempatan.')->group(function () {
    Route::get('/', PenempatanIndex::class)->name('index');
    Route::get('/create', PenempatanCreate::class)->name('create');
    Route::get('/{penempatan}/edit', PenempatanEdit::class)->name('edit');
    Route::get('/{id_penempatan}', PenempatanShow::class)->name('show');
  });

  Route::prefix('admin/evaluasi')->name('admin.evaluasi.')->group(function () {
    Route::get('/{id_evaluasi}', App\Livewire\Admin\Evaluasi\Show::class)->name('show');
    Route::get('/', App\Livewire\Admin\Evaluasi\Index::class)->name('index');
  });

  Route::prefix('admin/kontrak')->name('admin.kontrak.')->group(function () {
    Route::get('/', App\Livewire\Admin\Kontrak\Index::class)->name('index');

    Route::get('/{id_karyawan}', App\Livewire\Admin\Kontrak\Show::class)->name('show');
  });
});
