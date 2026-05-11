<?php

namespace App\Livewire\Admin\Kriteria;

use App\Models\KriteriaPenilaian;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Edit Kriteria Penilaian')]
class Edit extends Component
{
    public KriteriaPenilaian $kriteria;

    public $nama_kriteria, $bobot_nilai, $is_aktif;

    public function mount(KriteriaPenilaian $kriteria)
    {
        $this->kriteria = $kriteria;
        $this->nama_kriteria = $kriteria->nama_kriteria;
        $this->bobot_nilai = $kriteria->bobot_nilai;
        $this->is_aktif = (bool) $kriteria->is_aktif;
    }

    protected function rules()
    {
        return [
            'nama_kriteria' => 'required|string|max:150',
            'bobot_nilai' => 'required|numeric|min:0.01|max:100',
            'is_aktif' => 'boolean',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $dataLama = $this->kriteria->toArray();

        DB::transaction(function () use ($validated, $dataLama) {
            $this->kriteria->update($validated);

            LogAktivitas::catat(
                aksi: 'update',
                tabelTarget: 'kriteria_penilaians',
                idTarget: $this->kriteria->id_kriteria,
                dataLama: $dataLama,
                dataBaru: $this->kriteria->fresh()->toArray()
            );
        });

        session()->flash('message', 'Kriteria berhasil diperbarui.');
        return $this->redirectRoute('admin.kriteria.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.kriteria.edit');
    }
}
