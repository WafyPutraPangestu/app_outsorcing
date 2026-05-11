<?php

namespace App\Livewire\Admin\Klien;

use App\Models\Klien;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Daftar Klien - Valdo System')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;

    public function render()
    {
        // Mengambil data klien dengan optimasi query
        $kliens = Klien::query()
            ->select(['id_klien', 'nama_perusahaan', 'email_hrd_klien', 'nama_kontak_person'])
            ->when($this->search, function ($query) {
                $query->where('nama_perusahaan', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_kontak_person', 'like', '%' . $this->search . '%');
            })
            ->latest('id_klien')
            ->paginate($this->perPage);

        return view('livewire.admin.klien.index', [
            'kliens' => $kliens
        ]);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $klien = Klien::findOrFail($id);
        $klien->delete(); // Ini akan memicu SoftDeletes sesuai model

        session()->flash('message', 'Data klien berhasil dipindahkan ke tempat sampah.');
    }
}
