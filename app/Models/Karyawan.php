<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
