<?php

namespace App\Livewire\Admin\Evaluasi;

use App\Models\Evaluasi;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Show extends Component
{
    public Evaluasi $evaluasi;
    public $catatan_verifikator = '';

    public function mount($id_evaluasi)
    {
        // Memuat evaluasi beserta detail nilai, kriteria, dan data karyawan/klien (Anti N+1)
        $this->evaluasi = Evaluasi::query()
            ->with([
                'penempatan.karyawan',
                'penempatan.klien',
                'detail.kriteria',
                'verifikator'
            ])
            ->findOrFail($id_evaluasi);

        $this->catatan_verifikator = $this->evaluasi->catatan_verifikator;
    }

    protected function rules()
    {
        return [
            'catatan_verifikator' => 'nullable|string|max:500',
        ];
    }

    /**
     * Proses Verifikasi (Mengesahkan Nilai)
     */
    public function verifikasi()
    {
        $this->validate();

        // Pastikan hanya evaluasi dengan status menunggu_verifikasi yang bisa diproses
        if ($this->evaluasi->status_evaluasi !== 'menunggu_verifikasi') {
            session()->flash('error', 'Status tidak valid untuk diverifikasi.');
            return;
        }

        $dataLama = $this->evaluasi->toArray();

        DB::transaction(function () use ($dataLama) {
            $this->evaluasi->update([
                'status_evaluasi'     => 'verified',
                'id_user_verifikator' => Auth::id(),
                'catatan_verifikator' => $this->catatan_verifikator,
                'verified_at'         => now(),
            ]);

            LogAktivitas::catat(
                aksi: 'verifikasi_evaluasi',
                tabelTarget: 'evaluasi',
                idTarget: $this->evaluasi->id_evaluasi,
                dataLama: $dataLama,
                dataBaru: $this->evaluasi->fresh()->toArray()
            );
        });

        session()->flash('message', 'Evaluasi berhasil diverifikasi dan disahkan.');
        return $this->redirectRoute('admin.evaluasi.index', navigate: true);
    }

    /**
     * Proses Penolakan Data (Jika ada yang janggal)
     */
    public function tolak()
    {
        $this->validate([
            'catatan_verifikator' => 'required|string|max:500' // Wajib diisi jika menolak
        ]);

        if ($this->evaluasi->status_evaluasi !== 'menunggu_verifikasi') {
            session()->flash('error', 'Status tidak valid untuk ditolak.');
            return;
        }

        $dataLama = $this->evaluasi->toArray();

        DB::transaction(function () use ($dataLama) {
            $this->evaluasi->update([
                'status_evaluasi'     => 'rejected',
                'id_user_verifikator' => Auth::id(),
                'catatan_verifikator' => $this->catatan_verifikator,
            ]);

            LogAktivitas::catat(
                aksi: 'reject_evaluasi',
                tabelTarget: 'evaluasi',
                idTarget: $this->evaluasi->id_evaluasi,
                dataLama: $dataLama,
                dataBaru: $this->evaluasi->fresh()->toArray()
            );
        });

        session()->flash('message', 'Evaluasi ditolak. Klien mungkin perlu mengisi ulang.');
        return $this->redirectRoute('admin.evaluasi.index', navigate: true);
    }

    #[Title('Detail Verifikasi Evaluasi')]
    public function render()
    {
        return view('livewire.admin.evaluasi.show');
    }
}
