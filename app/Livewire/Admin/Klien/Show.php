<?php

namespace App\Livewire\Admin\Klien;

use App\Models\Klien;
use Livewire\Component;
use Livewire\Attributes\Title;

class Show extends Component
{
    public Klien $klien;

    public function mount($id_klien)
    {
        // Eager load penempatan dan karyawan untuk efisiensi (Anti N+1)
        $this->klien = Klien::with(['penempatan.karyawan'])
            ->findOrFail($id_klien);
    }

    #[Title('Profil Klien')]
    public function render()
    {
        return view('livewire.admin.klien.show');
    }
}
