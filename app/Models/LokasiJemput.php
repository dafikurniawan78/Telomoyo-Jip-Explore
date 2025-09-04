<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiJemput extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lokasi'
    ];

    public $timestamps = true;

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'lokasi_jemput_id');
    }
}
