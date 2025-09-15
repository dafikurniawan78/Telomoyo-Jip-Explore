<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrean extends Model
{
    use HasFactory;

    protected $table = 'antreans';

    protected $fillable = [
        'pemesanan_id',
        'nomor_antrean',
        'status',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class);
    }

    public function alokasiJip()
    {
        return $this->hasOne(AlokasiJip::class);
    }
}
