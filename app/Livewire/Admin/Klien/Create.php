<?php

namespace App\Livewire\Admin\Klien;

use App\Models\Klien;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Tambah Klien Baru')]
class Create extends Component
{
    public $nama_perusahaan, $alamat_kantor, $email_hrd_klien, $nama_kontak_person;

    protected function rules()
    {
        return [
            'nama_perusahaan' => 'required|string|max:200',
            'alamat_kantor'   => 'nullable|string',
            'email_hrd_klien' => 'required|email|max:150',
            'nama_kontak_person' => 'nullable|string|max:150',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $klien = Klien::create($validated);

            LogAktivitas::catat(
                aksi: 'create',
                tabelTarget: 'klien',
                idTarget: $klien->id_klien,
                dataBaru: $klien->toArray()
            );
        });

        session()->flash('message', 'Klien berhasil didaftarkan.');
        return $this->redirectRoute('admin.klien.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.klien.create');
    }
}
