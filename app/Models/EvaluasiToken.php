<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class EvaluasiToken extends Model
{
    protected $table = 'evaluasi_tokens';
    protected $primaryKey = 'id_token';

    protected $fillable = [
        'id_evaluasi',
        'token',
        'email_tujuan',
        'status',
        'expired_at',
    ];

    protected function casts(): array
    {
        return [
            'expired_at' => 'datetime',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();
        static::creating(function (self $model) {
            if (empty($model->token)) {
                $model->token = (string) Str::uuid();
            }
        });
    }

    // ─── Relationships ───
    public function evaluasi(): BelongsTo
    {
        return $this->belongsTo(Evaluasi::class, 'id_evaluasi', 'id_evaluasi');
    }
}
