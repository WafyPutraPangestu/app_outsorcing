<?php

namespace App\Livewire\Admin\Kriteria;

use App\Models\KriteriaPenilaian;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Tambah Kriteria Penilaian')]
class Create extends Component
{
    public $nama_kriteria;
    public $bobot_nilai;
    public $is_aktif = true;

    protected function rules()
    {
        return [
            'nama_kriteria' => 'required|string|max:150',
            // Validasi: bobot harus angka desimal, minimal 0.01 dan maksimal 100
            'bobot_nilai' => 'required|numeric|min:0.01|max:100',
            'is_aktif' => 'boolean',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        DB::transaction(function () use ($validated) {
            $kriteria = KriteriaPenilaian::create($validated);

            LogAktivitas::catat(
                aksi: 'create',
                tabelTarget: 'kriteria_penilaians',
                idTarget: $kriteria->id_kriteria,
                dataBaru: $kriteria->toArray()
            );
        });

        session()->flash('message', 'Kriteria berhasil ditambahkan.');
        return $this->redirectRoute('admin.kriteria.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.kriteria.create');
    }
}
