<?php

namespace App\Livewire\Admin\Penempatan;

use App\Models\Penempatan;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Title('Data Penempatan - Valdo System')]
class Index extends Component
{
    use WithPagination;

    #[Url(history: true)]
    public $search = '';

    public $perPage = 10;

    public function render()
    {
        // Optimasi: Menggunakan with() untuk mencegah N+1 Query pada relasi Karyawan dan Klien
        $penempatans = Penempatan::query()
            ->with([
                'karyawan:id_karyawan,nama_karyawan,nik',
                'klien:id_klien,nama_perusahaan'
            ])
            ->when($this->search, function ($query) {
                // Pencarian canggih: Mencari di tabel relasi
                $query->whereHas('karyawan', function ($q) {
                    $q->where('nama_karyawan', 'like', '%' . $this->search . '%');
                })->orWhereHas('klien', function ($q) {
                    $q->where('nama_perusahaan', 'like', '%' . $this->search . '%');
                });
            })
            ->latest('id_penempatan')
            ->paginate($this->perPage);

        return view('livewire.admin.penempatan.index', [
            'penempatans' => $penempatans
        ]);
    }

    // Mereset halaman ke 1 setiap kali user mengetik di kolom pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $penempatan = Penempatan::findOrFail($id);
        $penempatan->delete();

        session()->flash('message', 'Data penempatan berhasil dihapus.');
    }
}
