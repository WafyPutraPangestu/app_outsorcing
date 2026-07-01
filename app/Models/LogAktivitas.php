<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class LogAktivitas extends Model
{
    protected $table = 'log_aktivitas';
    protected $primaryKey = 'id_log';

    // Log tidak boleh diupdate, hanya insert
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'aksi',
        'tabel_target',
        'id_target',
        'data_lama',
        'data_baru',
        'ip_address',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'data_lama'  => 'array',
            'data_baru'  => 'array',
            'created_at' => 'datetime',
        ];
    }

    // ─── Static Helper ─────────────────────────────────────────

    public static function catat(
        string $aksi,
        ?int $idUser = null,
        ?string $tabelTarget = null,
        ?int $idTarget = null,
        mixed $dataLama = null,
        mixed $dataBaru = null,
    ): self {
        return self::create([
            'id_user'      => $idUser ?? Auth::id(),
            'aksi'         => $aksi,
            'tabel_target' => $tabelTarget,
            'id_target'    => $idTarget,
            'data_lama'    => $dataLama,
            'data_baru'    => $dataBaru,
            'ip_address'   => request()->ip(),
            'created_at'   => now(),
        ]);
    }

    // ─── Relationships ─────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
