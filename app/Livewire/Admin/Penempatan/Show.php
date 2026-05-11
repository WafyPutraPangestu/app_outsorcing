<?php

namespace App\Livewire\Admin\Penempatan;

use App\Models\Penempatan;
use Livewire\Component;
use Livewire\Attributes\Title;

class Show extends Component
{
    public Penempatan $penempatan;

    public function mount($id_penempatan)
    {
        // Memuat relasi karyawan, klien, dan riwayat evaluasinya nanti
        $this->penempatan = Penempatan::query()
            ->with(['karyawan', 'klien', 'evaluasi'])
            ->findOrFail($id_penempatan);
    }

    #[Title('Detail Penempatan')]
    public function render()
    {
        return view('livewire.admin.penempatan.show');
    }
}
