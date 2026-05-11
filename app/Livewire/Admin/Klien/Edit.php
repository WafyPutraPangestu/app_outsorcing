<?php

namespace App\Livewire\Admin\Klien;

use App\Models\Klien;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Edit Data Klien')]
class Edit extends Component
{
    public Klien $klien;
    public $nama_perusahaan, $alamat_kantor, $email_hrd_klien, $nama_kontak_person;

    public function mount(Klien $klien)
    {
        $this->klien = $klien;
        $this->fill($klien->toArray());
    }

    protected function rules()
    {
        return [
            'nama_perusahaan' => 'required|string|max:200',
            'alamat_kantor'   => 'nullable|string',
            'email_hrd_klien' => 'required|email|max:150',
            'nama_kontak_person' => 'nullable|string|max:150',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $dataLama = $this->klien->toArray();

        DB::transaction(function () use ($validated, $dataLama) {
            $this->klien->update($validated);

            LogAktivitas::catat(
                aksi: 'update',
                tabelTarget: 'klien',
                idTarget: $this->klien->id_klien,
                dataLama: $dataLama,
                dataBaru: $this->klien->fresh()->toArray()
            );
        });

        session()->flash('message', 'Data klien berhasil diperbarui.');
        return $this->redirectRoute('admin.klien.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.klien.edit'); // Pastikan nama file view sesuai
    }
}
