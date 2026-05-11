<?php

namespace App\Livewire\Admin\Kriteria;

use App\Models\KriteriaPenilaian;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;

#[Title('Kriteria Penilaian - Valdo System')]
class Index extends Component
{
    use WithPagination;

    public $perPage = 10;

    /**
     * #[Computed] akan melakukan cache (penyimpanan sementara) pada request ini.
     * Kita menggunakan query sum() langsung ke database agar sangat ringan dan cepat,
     * tidak peduli seberapa banyak jumlah kriteria yang ada (O(1) Memory).
     */
    #[Computed]
    public function totalBobotAktif()
    {
        // Tambahkan ->query() setelah nama Model untuk menghilangkan error Intelephense
        return KriteriaPenilaian::query()->where('is_aktif', true)->sum('bobot_nilai');
    }

    /**
     * Fitur cepat untuk menyalakan/mematikan kriteria langsung dari tabel
     */
    public function toggleStatus($id)
    {
        $kriteria = KriteriaPenilaian::findOrFail($id);
        $kriteria->is_aktif = !$kriteria->is_aktif;
        $kriteria->save();

        // Tetap catat aktivitas demi keamanan audit
        LogAktivitas::catat(
            aksi: 'toggle_status',
            tabelTarget: 'kriteria_penilaians',
            idTarget: $kriteria->id_kriteria,
            dataBaru: ['is_aktif' => $kriteria->is_aktif]
        );
    }

    public function render()
    {
        // Optimasi: Hanya select kolom yang benar-benar ditampilkan di tabel
        $kriterias = KriteriaPenilaian::query()
            ->select(['id_kriteria', 'nama_kriteria', 'bobot_nilai', 'is_aktif'])
            ->latest('id_kriteria')
            ->paginate($this->perPage);

        return view('livewire.admin.kriteria.index', [
            'kriterias' => $kriterias
        ]);
    }
}
