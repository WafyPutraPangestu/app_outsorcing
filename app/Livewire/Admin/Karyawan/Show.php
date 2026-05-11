<?php

namespace App\Livewire\Admin\Karyawan;

use App\Models\Karyawan;
use Livewire\Component;
use Livewire\Attributes\Title;

class Show extends Component
{
    public Karyawan $karyawan;

    public function mount($id_karyawan)
    {
        // Eager loading penempatan dan klien untuk menghindari N+1 query
        $this->karyawan = Karyawan::with(['penempatan.klien'])
            ->findOrFail($id_karyawan);
    }

    #[Title('Detail Karyawan')]
    public function render()
    {
        return view('livewire.admin.karyawan.show');
    }
}
