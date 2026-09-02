<?php

namespace App\Livewire\Admin\Karyawan;

use App\Models\Karyawan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public Karyawan $karyawan;

    // Properti form (binding langsung ke model agar ringkas)
    public $nik, $nama_karyawan, $jenis_kelamin, $alamat, $no_hp, $posisi, $status_karyawan, $foto_baru;

    public function mount(Karyawan $karyawan)
    {
        $this->karyawan = $karyawan;
        $this->fill($karyawan->toArray());
    }

    protected function rules()
    {
        return [
            'nik' => 'required|max:50|unique:karyawan,nik,' . $this->karyawan->id_karyawan . ',id_karyawan',
            'nama_karyawan' => 'required|string|max:150',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status_karyawan' => 'required|in:aktif,nonaktif',
            'posisi' => 'required|string|max:100',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'foto_baru' => 'nullable|image|max:2048',
        ];
    }

    public function update()
    {
        $validated = $this->validate();

        if ($this->foto_baru) {
            if ($this->karyawan->foto) {
                Storage::disk('public')->delete($this->karyawan->foto);
            }
            $validated['foto'] = $this->foto_baru->store('karyawan', 'public');
        }

        $dataLama = $this->karyawan->toArray();

        DB::transaction(function () use ($validated, $dataLama) {
            $this->karyawan->update($validated);

            LogAktivitas::catat(
                aksi: 'update',
                tabelTarget: 'karyawan',
                idTarget: $this->karyawan->id_karyawan,
                dataLama: $dataLama,
                dataBaru: $this->karyawan->fresh()->toArray()
            );
        });

        session()->flash('message', 'Data berhasil diperbarui.');
        return $this->redirectRoute('admin.karyawan.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.karyawan.edit');
    }
}
