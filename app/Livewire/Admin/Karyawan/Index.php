<?php

namespace App\Livewire\Admin\Karyawan;

use App\Models\Karyawan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Daftar Karyawan - Valdo System')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;

    /**
     * Mengoptimalkan query dengan membatasi kolom yang diambil
     * dan memastikan tidak ada N+1 jika nanti ada relasi penempatan.
     */
    public function render()
    {
        $karyawans = Karyawan::query()
            ->select(['id_karyawan', 'nik', 'nama_karyawan', 'posisi', 'status_karyawan'])
            ->when($this->search, function ($query) {
                $query->where('nama_karyawan', 'like', '%' . $this->search . '%')
                    ->orWhere('nik', 'like', '%' . $this->search . '%');
            })
            ->latest('id_karyawan')
            ->paginate($this->perPage);

        return view('livewire.admin.karyawan.index', [
            'karyawans' => $karyawans
        ]);
    }

    /**
     * Reset pagination saat mencari agar tidak stuck di page terakhir
     */
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();

        session()->flash('message', 'Karyawan berhasil dihapus.');
    }
}
