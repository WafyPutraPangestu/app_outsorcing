<?php

namespace App\Livewire\Admin\Penempatan;

use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Penempatan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Tambah Penempatan Kerja')]
class Create extends Component
{
    public $id_karyawan;
    public $id_klien;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status_aktif = true;

    protected function rules()
    {
        return [
            'id_karyawan'     => 'required|exists:karyawan,id_karyawan',
            'id_klien'        => 'required|exists:klien,id_klien',
            'tanggal_mulai'   => 'required|date',
            // Pastikan tanggal selesai boleh kosong, tapi jika diisi harus setelah tanggal mulai
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif'    => 'boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $penempatan = Penempatan::create($validated);

            LogAktivitas::catat(
                aksi: 'create',
                tabelTarget: 'penempatans',
                idTarget: $penempatan->id_penempatan,
                dataBaru: $penempatan->toArray()
            );
        });

        session()->flash('message', 'Penempatan karyawan berhasil disimpan.');
        return $this->redirectRoute('admin.penempatan.index', navigate: true);
    }

    public function render()
    {
        // Mengirim data karyawan aktif dan semua klien untuk dropdown form
        return view('livewire.admin.penempatan.create', [
            'karyawans' => Karyawan::query()->where('status_karyawan', 'aktif')->get(['id_karyawan', 'nama_karyawan', 'nik']),
            'kliens'    => Klien::query()->get(['id_klien', 'nama_perusahaan']),
        ]);
    }
}
