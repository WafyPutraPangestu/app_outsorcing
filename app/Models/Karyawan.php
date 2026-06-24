<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Karyawan extends Model
{
    use SoftDeletes;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nik',
        'nama_karyawan',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'posisi',
        'status_karyawan'
    ];

    // ─── Relationships ───
    public function penempatan(): HasMany
    {
        return $this->hasMany(Penempatan::class, 'id_karyawan', 'id_karyawan');
    }


    // Semua riwayat kontrak karyawan
    public function kontrak(): HasMany
    {
        return $this->hasMany(kontrak_karyawan::class, 'id_karyawan', 'id_karyawan');
    }

    // Kontrak yang sedang aktif saja
    public function kontrakAktif(): HasOne
    {
        return $this->hasOne(kontrak_karyawan::class, 'id_karyawan', 'id_karyawan')
            ->where('status', 'aktif')
            ->latestOfMany('tanggal_mulai');
    }
}
