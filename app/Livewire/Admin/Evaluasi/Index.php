<?php

namespace App\Livewire\Admin\Evaluasi;

use App\Models\Evaluasi;
use App\Models\Penempatan;
use App\Models\EvaluasiToken;
use App\Models\LogAktivitas;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Mail\MagicLinkEmail;
use Illuminate\Support\Facades\Mail;

#[Title('Data Evaluasi Bulanan - Valdo System')]
class Index extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public function render()
    {
        $evaluasis = Evaluasi::query()
            ->with([
                'penempatan.karyawan:id_karyawan,nama_karyawan',
                'penempatan.klien:id_klien,nama_perusahaan',
                'verifikator:id,name'
            ])
            ->when($this->search, function ($query) {
                $query->where('periode', 'like', '%' . $this->search . '%')
                    ->orWhere('status_evaluasi', 'like', '%' . $this->search . '%');
            })
            ->latest('id_evaluasi')
            ->paginate($this->perPage);
        $penempatanAktif = Penempatan::with(['karyawan', 'klien'])
            ->where('status_aktif', true)
            ->get();
        return view('livewire.admin.evaluasi.index', [
            'evaluasis' => $evaluasis,
            'penempatanAktif' => $penempatanAktif
        ]);
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    /**
     * Fitur Utama: Generate Evaluasi & Magic Link
     * Fungsi ini akan membuat record evaluasi baru dan token unik untuk dikirim ke Klien
     */
    public function generateMagicLink($id_penempatan)
    {
        $penempatan = Penempatan::with('klien')->findOrFail($id_penempatan);
        $periodeSekarang = now()->format('Y-m');
        $cekEvaluasi = Evaluasi::query()->where('id_penempatan', $id_penempatan)
            ->where('periode', $periodeSekarang)
            ->first();
        if ($cekEvaluasi) {
            session()->flash('error', 'Evaluasi untuk periode ' . $periodeSekarang . ' sudah ada!');
            return;
        }
        DB::transaction(function () use ($penempatan, $periodeSekarang) {
            $evaluasi = Evaluasi::create([
                'id_penempatan'   => $penempatan->id_penempatan,
                'periode'         => $periodeSekarang,
                'status_evaluasi' => 'menunggu_klien',
            ]);
            $token = EvaluasiToken::create([
                'id_evaluasi'  => $evaluasi->id_evaluasi,
                'email_tujuan' => $penempatan->klien->email_hrd_klien,
                'status'       => 'unused',
                'expired_at'   => now()->addDays(7),
            ]);
            LogAktivitas::catat(
                aksi: 'generate_magic_link',
                tabelTarget: 'evaluasi_tokens',
                idTarget: $token->id_token,
                dataBaru: ['email_tujuan' => $token->email_tujuan, 'periode' => $periodeSekarang]
            );
            Mail::to($token->email_tujuan)->send(new MagicLinkEmail($token));
        });
        session()->flash('message', 'Magic Link berhasil dibuat dan dikirim ke email Klien.');
    }
}
