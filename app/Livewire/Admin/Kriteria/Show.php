<?php

namespace App\Livewire\Admin\Kriteria;

use App\Models\KriteriaPenilaian;
use Livewire\Component;
use Livewire\Attributes\Title;

class Show extends Component
{
    public KriteriaPenilaian $kriteria;

    public function mount($id_kriteria)
    {
        // Menggunakan findOrFail untuk keamanan:
        // Jika ID tidak ditemukan, otomatis menampilkan halaman 404
        $this->kriteria = KriteriaPenilaian::findOrFail($id_kriteria);
    }

    #[Title('Detail Kriteria')]
    public function render()
    {
        return view('livewire.admin.kriteria.show');
    }
}
