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
        'jam_berangkat',
        'jumlah_orang',
        'jumlah_jip',
        'lokasi_jemput_id',
        'paket_id',
        'total',
        'status',
        'bukti_pembayaran',
    ];

    protected $casts = [
        'tanggal_berangkat' => 'date',
        'jam_berangkat' => 'datetime:H:i',
    ];

    /**
     * Relasi ke Paket Wisata
     */
    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paket_id');
    }

    /**
     * Relasi ke Lokasi Jemput
     */
    public function lokasiJemput()
    {
        return $this->belongsTo(LokasiJemput::class, 'lokasi_jemput_id');
    }

    /**
     * Relasi ke User
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Relasi ke Antrean
     */
    public function antrean()
    {
        return $this->hasOne(Antrean::class);
    }

    /**
     * Relasi ke Alokasi Jip
     */
    public function alokasiJip()
    {
        return $this->hasOne(AlokasiJip::class);
    }
}
