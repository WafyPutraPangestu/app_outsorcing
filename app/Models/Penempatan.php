<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penempatan extends Model
{
    // Disesuaikan dengan migration
    protected $table = 'penempatans';
    protected $primaryKey = 'id_penempatan';

    protected $fillable = [
        'id_karyawan',
        'id_klien',
        'tanggal_mulai',
        'tanggal_selesai',
        'status_aktif',
        'rekomendasi_sistem'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai'   => 'date',
            'tanggal_selesai' => 'date',
            'status_aktif'    => 'boolean',
        ];
    }

    // ─── Relationships ───
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function klien(): BelongsTo
    {
        return $this->belongsTo(Klien::class, 'id_klien', 'id_klien');
    }

    public function evaluasi(): HasMany
    {
        return $this->hasMany(Evaluasi::class, 'id_penempatan', 'id_penempatan');
    }
}
