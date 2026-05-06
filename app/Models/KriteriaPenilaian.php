<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KriteriaPenilaian extends Model
{
    // Disesuaikan dengan nama migration
    protected $table = 'kriteria_penilaians';
    protected $primaryKey = 'id_kriteria';

    protected $fillable = [
        'nama_kriteria',
        'bobot_nilai',
        'is_aktif',
    ];

    protected function casts(): array
    {
        return [
            'bobot_nilai' => 'decimal:2',
            'is_aktif'    => 'boolean',
        ];
    }

    // ─── Relationships ───
    public function detailEvaluasi(): HasMany
    {
        return $this->hasMany(detail_evaluasi::class, 'id_kriteria', 'id_kriteria');
    }
}
