<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jip extends Model
{
    use HasFactory;

    protected $table = 'jips';

    protected $fillable = [
        'plat_nomor',
        'kapasitas',
        'driver',
        'status',
    ];

    // Semua alokasi jip
    public function alokasiJip()
    {
        return $this->hasMany(AlokasiJip::class, 'jip_id', 'id');
    }

    // Alokasi yang sedang aktif (sedang digunakan)
    public function alokasiJipAktif()
    {
        return $this->hasOne(AlokasiJip::class, 'jip_id', 'id')
            ->where('waktu_mulai', '<=', now())
            ->where('waktu_selesai', '>=', now());
    }
}
