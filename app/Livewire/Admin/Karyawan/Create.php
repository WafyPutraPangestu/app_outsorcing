<?php

namespace App\Livewire\Admin\Karyawan;

use App\Models\Karyawan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

#[Title('Tambah Karyawan Baru')]
class Create extends Component
{
    use WithFileUploads;

    // Form Properties
    public $nik, $nama_karyawan, $jenis_kelamin = 'Laki-laki', $alamat, $no_hp, $posisi, $foto;

    protected function rules()
    {
        return [
            'nik' => 'required|unique:karyawan,nik|max:50',
            'nama_karyawan' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|numeric|digits_between:10,15',
            'posisi' => 'required|string|max:100',
            'foto' => 'nullable|image|max:2048',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        if ($this->foto) {
            $validated['foto'] = $this->foto->store('karyawan', 'public');
        }

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
