<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Perbaikan: Di migration defaultnya 'id', bukan 'id_user'
    protected $primaryKey = 'id';

    protected $fillable = [
        'role',
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManajemen(): bool
    {
        return $this->role === 'manajemen';
    }

    // ─── Relationships ───
    public function evaluasiDiverifikasi(): HasMany
    {
        return $this->hasMany(Evaluasi::class, 'id_user_verifikator', 'id');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'id_user', 'id');
    }
}
