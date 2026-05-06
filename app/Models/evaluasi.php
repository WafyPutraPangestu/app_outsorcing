<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Evaluasi extends Model
{
    protected $table = 'evaluasi';
    protected $primaryKey = 'id_evaluasi';

    protected $fillable = [
        'id_penempatan',
        'periode',
        'total_nilai_akhir',
        'komentar_klien',
        'tanggal_diisi_klien',
        'status_evaluasi',
        'id_user_verifikator',
        'catatan_verifikator',
        'verified_at'
    ];

    protected function casts(): array
    {
        return [
            'tanggal_diisi_klien' => 'date',
            'verified_at' => 'datetime',
            'total_nilai_akhir' => 'decimal:2'
        ];
    }

    // ─── Relationships ───
    public function penempatan(): BelongsTo
    {
        return $this->belongsTo(Penempatan::class, 'id_penempatan', 'id_penempatan');
    }

    public function verifikator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user_verifikator', 'id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(detail_evaluasi::class, 'id_evaluasi', 'id_evaluasi');
    }

    public function token(): HasOne
    {
        return $this->hasOne(EvaluasiToken::class, 'id_evaluasi', 'id_evaluasi');
    }
}
