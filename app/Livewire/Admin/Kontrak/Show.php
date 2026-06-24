<?php

namespace App\Livewire\Admin\Kontrak;

use App\Models\Karyawan;
use App\Models\kontrak_karyawan;
use App\Models\LogAktivitas;
use Livewire\Component;

class Show extends Component
{
    public Karyawan $karyawan;
    public int $id_karyawan;

    // Modal state
    public bool $showModalKontrak = false;
    public bool $showModalPutus   = false;
    public string $modeModal      = 'buat'; // buat | perpanjang | edit

    // Form fields
    public string $tanggal_mulai   = '';
    public string $tanggal_selesai = '';
    public string $catatan         = '';
    public ?int   $editingId       = null;

    // Konfirmasi putus kontrak
    public string $alasan_putus = '';

    protected function rules(): array
    {
        return [
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'catatan'         => 'nullable|string|max:500',
        ];
    }

    protected function messages(): array
    {
        return [
            'tanggal_mulai.required'      => 'Tanggal mulai wajib diisi.',
            'tanggal_selesai.required'    => 'Tanggal selesai wajib diisi.',
            'tanggal_selesai.after'       => 'Tanggal selesai harus setelah tanggal mulai.',
        ];
    }

    public function mount(int $id_karyawan): void
    {
        $this->karyawan    = Karyawan::findOrFail($id_karyawan);
        $this->id_karyawan = $id_karyawan;
    }

    // ─── Open Modals ───

    public function bukaMOdalBuat(): void
    {
        $this->resetForm();
        $this->modeModal      = 'buat';
        $this->tanggal_mulai  = now()->format('Y-m-d');
        $this->showModalKontrak = true;
    }

    public function bukaModalPerpanjang(): void
    {
        $kontrakAktif = $this->karyawan->kontrakAktif;
        if (!$kontrakAktif) return;

        $this->resetForm();
        $this->modeModal      = 'perpanjang';
        // Otomatis mulai dari hari setelah kontrak lama selesai
        $this->tanggal_mulai  = $kontrakAktif->tanggal_selesai->addDay()->format('Y-m-d');
        $this->showModalKontrak = true;
    }

    public function bukaModalEdit(int $id): void
    {
        $kontrak = kontrak_karyawan::findOrFail($id);
        $this->resetForm();
        $this->modeModal      = 'edit';
        $this->editingId      = $id;
        $this->tanggal_mulai  = $kontrak->tanggal_mulai->format('Y-m-d');
        $this->tanggal_selesai = $kontrak->tanggal_selesai->format('Y-m-d');
        $this->catatan        = $kontrak->catatan ?? '';
        $this->showModalKontrak = true;
    }

    public function bukaModalPutus(): void
    {
        $this->alasan_putus = '';
        $this->showModalPutus = true;
    }

    // ─── Actions ───

    public function simpanKontrak(): void
    {
        $this->validate();

        if ($this->modeModal === 'edit') {
            $kontrak      = kontrak_karyawan::findOrFail($this->editingId);
            $dataLama     = $kontrak->toArray();
            $kontrak->update([
                'tanggal_mulai'   => $this->tanggal_mulai,
                'tanggal_selesai' => $this->tanggal_selesai,
                'catatan'         => $this->catatan,
            ]);

            LogAktivitas::catat(
                aksi: 'update',
                tabelTarget: 'kontrak_karyawan',
                idTarget: $kontrak->id_kontrak,
                dataLama: $dataLama,
                dataBaru: $kontrak->fresh()->toArray(),
            );

            session()->flash('toast_success', 'Kontrak berhasil diperbarui.');
        } elseif ($this->modeModal === 'perpanjang') {
            $kontrakLama  = $this->karyawan->kontrakAktif;

            // Nonaktifkan kontrak lama
            $kontrakLama->update(['status' => 'selesai']);

            $nomorUrut = $this->karyawan->kontrak()->count() + 1;

            $kontrakBaru = kontrak_karyawan::create([
                'id_karyawan'            => $this->id_karyawan,
                'tanggal_mulai'          => $this->tanggal_mulai,
                'tanggal_selesai'        => $this->tanggal_selesai,
                'jenis_kontrak'          => 'perpanjangan',
                'nomor_urut_kontrak'     => $nomorUrut,
                'id_kontrak_sebelumnya'  => $kontrakLama->id_kontrak,
                'catatan'                => $this->catatan,
                'status'                 => 'aktif',
            ]);

            LogAktivitas::catat(
                aksi: 'perpanjang_kontrak',
                tabelTarget: 'kontrak_karyawan',
                idTarget: $kontrakBaru->id_kontrak,
                dataBaru: $kontrakBaru->toArray(),
            );

            session()->flash('toast_success', 'Kontrak berhasil diperpanjang.');
        } else {
            // Buat kontrak awal
            $kontrakBaru = kontrak_karyawan::create([
                'id_karyawan'        => $this->id_karyawan,
                'tanggal_mulai'      => $this->tanggal_mulai,
                'tanggal_selesai'    => $this->tanggal_selesai,
                'jenis_kontrak'      => 'kontrak_awal',
                'nomor_urut_kontrak' => 1,
                'catatan'            => $this->catatan,
                'status'             => 'aktif',
            ]);

            LogAktivitas::catat(
                aksi: 'buat_kontrak',
                tabelTarget: 'kontrak_karyawan',
                idTarget: $kontrakBaru->id_kontrak,
                dataBaru: $kontrakBaru->toArray(),
            );

            session()->flash('toast_success', 'Kontrak awal berhasil dibuat.');
        }

        $this->showModalKontrak = false;
        $this->resetForm();
        $this->karyawan->refresh();
    }

    public function putusKontrak(): void
    {
        $kontrakAktif = $this->karyawan->kontrakAktif;
        if (!$kontrakAktif) return;

        $dataLama = $kontrakAktif->toArray();

        $kontrakAktif->update([
            'status'  => 'dibatalkan',
            'catatan' => $this->alasan_putus
                ? ($kontrakAktif->catatan ? $kontrakAktif->catatan . "\n[Putus: {$this->alasan_putus}]" : "Putus kontrak: {$this->alasan_putus}")
                : $kontrakAktif->catatan,
        ]);

        LogAktivitas::catat(
            aksi: 'putus_kontrak',
            tabelTarget: 'kontrak_karyawan',
            idTarget: $kontrakAktif->id_kontrak,
            dataLama: $dataLama,
            dataBaru: $kontrakAktif->fresh()->toArray(),
        );

        $this->showModalPutus = false;
        $this->alasan_putus   = '';
        $this->karyawan->refresh();

        session()->flash('toast_success', 'Kontrak berhasil diputus.');
    }

    // ─── Helpers ───

    private function resetForm(): void
    {
        $this->tanggal_mulai   = '';
        $this->tanggal_selesai = '';
        $this->catatan         = '';
        $this->editingId       = null;
        $this->resetValidation();
    }

    public function render()
    {
        $riwayatKontrak = $this->karyawan
            ->kontrak()
            ->orderBy('nomor_urut_kontrak', 'desc')
            ->get();

        $kontrakAktif = $this->karyawan->kontrakAktif;

        return view('livewire.admin.kontrak.show', compact('riwayatKontrak', 'kontrakAktif'));
    }
}
