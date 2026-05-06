<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailEvaluasi extends Model
{
    protected $table = 'detail_evaluasi';
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_evaluasi',
        'id_kriteria',
        'skor_nilai',
    ];

    protected function casts(): array
    {
        return [
            'skor_nilai' => 'decimal:2',
        ];
    }

    // ─── Relationships ───
    public function evaluasi(): BelongsTo
    {
        return $this->belongsTo(Evaluasi::class, 'id_evaluasi', 'id_evaluasi');
    }

    public function kriteria(): BelongsTo
    {
        return $this->belongsTo(KriteriaPenilaian::class, 'id_kriteria', 'id_kriteria');
    }
}
