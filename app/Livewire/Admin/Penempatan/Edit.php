<?php

namespace App\Livewire\Admin\Penempatan;

use App\Models\Karyawan;
use App\Models\Klien;
use App\Models\Penempatan;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;

#[Title('Edit Penempatan Kerja')]
class Edit extends Component
{
    public Penempatan $penempatan;

    public $id_karyawan;
    public $id_klien;
    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status_aktif;

    public function mount(Penempatan $penempatan)
    {
        $this->penempatan = $penempatan;
        $this->id_karyawan = $penempatan->id_karyawan;
        $this->id_klien = $penempatan->id_klien;
        // Format tanggal untuk input type="date" di HTML
        $this->tanggal_mulai = $penempatan->tanggal_mulai?->format('Y-m-d');
        $this->tanggal_selesai = $penempatan->tanggal_selesai?->format('Y-m-d');
        $this->status_aktif = (bool) $penempatan->status_aktif;
    }

    protected function rules()
    {
        return [
            'id_karyawan'     => 'required|exists:karyawan,id_karyawan',
            'id_klien'        => 'required|exists:klien,id_klien',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status_aktif'    => 'boolean',
        ];
    }

    public function update()
    {
        $validated = $this->validate();
        $dataLama = $this->penempatan->toArray();

        DB::transaction(function () use ($validated, $dataLama) {
            $this->penempatan->update($validated);

            LogAktivitas::catat(
                aksi: 'update',
                tabelTarget: 'penempatans',
                idTarget: $this->penempatan->id_penempatan,
                dataLama: $dataLama,
                dataBaru: $this->penempatan->fresh()->toArray()
            );
        });

        session()->flash('message', 'Penempatan karyawan berhasil diperbarui.');
        return $this->redirectRoute('admin.penempatan.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.penempatan.edit', [
            'karyawans' => Karyawan::query()->get(['id_karyawan', 'nama_karyawan', 'nik']),
            'kliens'    => Klien::query()->get(['id_klien', 'nama_perusahaan']),
        ]);
    }
}
