<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketWisata extends Model
{
    use HasFactory;

    protected $table = 'paket_wisatas';

    protected $fillable = [
        'nama_paket',
        'durasi',
        'harga',
        'deskripsi'
    ];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'paket_id');
    }
}
