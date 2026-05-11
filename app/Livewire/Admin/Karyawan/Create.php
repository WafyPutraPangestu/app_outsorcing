<?php

namespace App\Livewire\Admin\Karyawan;

use App\Models\Karyawan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Tambah Karyawan Baru')]
class Create extends Component
{
    // Form Properties
    public $nik, $nama_karyawan, $jenis_kelamin = 'Laki-laki', $alamat, $no_hp, $posisi;

    protected function rules()
    {
        return [
            'nik' => 'required|unique:karyawan,nik|max:50',
            'nama_karyawan' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|numeric|digits_between:10,15',
            'posisi' => 'required|string|max:100',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $karyawan = Karyawan::create($validated);

            // Logging Otomatis sesuai permintaan (Fitur Keamanan)
            LogAktivitas::catat(
                aksi: 'create',
                tabelTarget: 'karyawan',
                idTarget: $karyawan->id_karyawan,
                dataBaru: $karyawan->toArray()
            );
        });

        session()->flash('message', 'Data karyawan berhasil ditambahkan.');
        return $this->redirectRoute('admin.karyawan.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.karyawan.create');
    }
}
