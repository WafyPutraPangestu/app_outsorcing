<?php

namespace App\Livewire\Klien;

use App\Models\EvaluasiToken;
use App\Models\Evaluasi;
use App\Models\KriteriaPenilaian;
use App\Models\DetailEvaluasi;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.guest')]
#[Title('Form Evaluasi Karyawan')]
class IsiEvaluasi extends Component
{
    public $tokenString;
    public EvaluasiToken $tokenData;
    public $kriteriaList = [];
    public $skor = [];
    public $komentar_klien;
    public $isValid = true;
    public $pesanError = '';
    public function mount($token)
    {
        $this->tokenString = $token;
        $tokenRecord = EvaluasiToken::with(['evaluasi.penempatan.karyawan'])
            ->where('token', $token)
            ->first();
        if (!$tokenRecord) {
            $this->setInvalid('Tautan evaluasi tidak ditemukan.');
            return;
        }
        if ($tokenRecord->status === 'used') {
            $this->setInvalid('Tautan ini sudah pernah digunakan dan tidak berlaku lagi.');
            return;
        }
        if (now()->greaterThan($tokenRecord->expired_at)) {
            $this->setInvalid('Tautan ini sudah kedaluwarsa.');
            $tokenRecord->update(['status' => 'expired']);
            return;
        }
        $this->tokenData = $tokenRecord;
        $this->kriteriaList = KriteriaPenilaian::query()->where('is_aktif', true)->get();
        foreach ($this->kriteriaList as $kriteria) {
            $this->skor[$kriteria->id_kriteria] = '';
        }
    }
    private function setInvalid($pesan)
    {
        $this->isValid = false;
        $this->pesanError = $pesan;
    }
    public function save()
    {
        $rules = [
            'komentar_klien' => 'nullable|string|max:1000',
            'skor.*'         => 'required|numeric|min:0|max:100',
        ];
        $this->validate($rules);
        DB::transaction(function () {
            $evaluasi = $this->tokenData->evaluasi;
            $totalNilaiAkhir = 0;
            foreach ($this->kriteriaList as $kriteria) {
                $nilaiInput = $this->skor[$kriteria->id_kriteria];
                $nilaiBobot = ($nilaiInput * $kriteria->bobot_nilai) / 100;
                $totalNilaiAkhir += $nilaiBobot;
                DetailEvaluasi::create([
                    'id_evaluasi' => $evaluasi->id_evaluasi,
                    'id_kriteria' => $kriteria->id_kriteria,
                    'skor_nilai'  => $nilaiInput,
                ]);
            }
            $evaluasi->update([
                'total_nilai_akhir'   => $totalNilaiAkhir,
                'komentar_klien'      => $this->komentar_klien,
                'tanggal_diisi_klien' => now(),
                'status_evaluasi'     => 'menunggu_verifikasi',
            ]);
            $this->tokenData->update([
                'status' => 'used'
            ]);
        });
        session()->flash('message', 'Terima kasih! Evaluasi karyawan berhasil dikirim.');
        $this->isValid = false;
    }
    public function render()
    {
        return view('livewire.klien.isi-evaluasi');
    }
}
