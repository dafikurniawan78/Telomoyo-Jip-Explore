<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiJip extends Model
{
    use HasFactory;

    protected $table = 'alokasi_jips';

    protected $fillable = [
        'pemesanan_id',
        'jip_id',
        'waktu_mulai',
        'waktu_selesai',
    ];

    public function antrean()
    {
        return $this->belongsTo(Antrean::class);
    }

    public function jip()
    {
        return $this->belongsTo(Jip::class);
    }
}
