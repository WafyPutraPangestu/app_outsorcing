<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kontrak_karyawan extends Model
{
    protected $table = 'kontrak_karyawan';
    protected $primaryKey = 'id_kontrak';

    protected $fillable = [
        'id_karyawan',
        'tanggal_mulai',
        'tanggal_selesai',
        'jenis_kontrak',
        'nomor_urut_kontrak',
        'id_kontrak_sebelumnya',
        'catatan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    // ─── Relationships ───

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    // Kontrak induk (sebelumnya)
    public function kontrakSebelumnya(): BelongsTo
    {
        return $this->belongsTo(kontrak_karyawan::class, 'id_kontrak_sebelumnya', 'id_kontrak');
    }

    // Semua perpanjangan dari kontrak ini
    public function perpanjangan(): HasMany
    {
        return $this->hasMany(kontrak_karyawan::class, 'id_kontrak_sebelumnya', 'id_kontrak');
    }

    // ─── Helpers ───

    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }

    public function isPerpanjangan(): bool
    {
        return $this->jenis_kontrak === 'perpanjangan';
    }

    public function sisaHari(): int
    {
        return (int) now()->diffInDays($this->tanggal_selesai, false);
    }

    public function hampirHabis(int $hariSebelum = 30): bool
    {
        $sisa = $this->sisaHari();
        return $sisa <= $hariSebelum && $sisa >= 0;
    }

    public function sudahHabis(): bool
    {
        return $this->sisaHari() < 0;
    }
}
