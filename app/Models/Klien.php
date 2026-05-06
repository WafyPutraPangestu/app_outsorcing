<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Klien extends Model
{
    use SoftDeletes;

    protected $table = 'klien';
    protected $primaryKey = 'id_klien';

    protected $fillable = [
        'nama_perusahaan',
        'alamat_kantor',
        'email_hrd_klien',
        'nama_kontak_person',
    ];

    // ─── Relationships ───
    public function penempatan(): HasMany
    {
        return $this->hasMany(Penempatan::class, 'id_klien', 'id_klien');
    }
}
