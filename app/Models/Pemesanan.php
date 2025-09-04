<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemesanan extends Model
{
    use HasFactory;

    protected $table = 'pemesanans';

    protected $fillable = [
        'nama',
        'telepon',
        'tanggal_berangkat',
        'jumlah_orang',
        'jumlah_jip',
        'lokasi_jemput_id',
        'paket_id',
        'jam_berangkat',
        'total',
        'status',
        'bukti_pembayaran',
    ];

    // Relasi ke Paket Wisata
    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paket_id');
    }

    // Relasi ke Lokasi Jemput
    public function lokasiJemput()
    {
        return $this->belongsTo(LokasiJemput::class, 'lokasi_jemput_id');
    }
}
