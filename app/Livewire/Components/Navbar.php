<?php

namespace App\Livewire\Components;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Navbar extends Component
{
    /**
     * Fungsi untuk memproses logout user.
     */
    public function logout()
    {
        // 1. Catat log aktivitas sebelum sesi dihancurkan (opsional tapi bagus untuk audit)
        LogAktivitas::catat(
            aksi: 'logout',
            idUser: Auth::id()
        );

        // 2. Proses logout dari Guard Laravel
        Auth::logout();

        // 3. Menghancurkan sesi user agar tidak bisa digunakan kembali
        Session::invalidate();

        // 4. Membuat token CSRF baru untuk keamanan sesi berikutnya
        Session::regenerateToken();

        // 5. Redirect ke halaman login atau homepage
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.components.navbar');
    }
}
