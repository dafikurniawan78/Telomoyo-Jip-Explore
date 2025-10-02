<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlokasiJip extends Model
{
    use HasFactory;

    protected $table = 'alokasi_jips';

    protected $fillable = [
        'antrean_id',
        'jip_id',
        'waktu_mulai',
        'waktu_selesai',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
    ];

    public function antrean()
    {
        return $this->belongsTo(Antrean::class, 'antrean_id');
    }

    public function jip()
    {
        return $this->belongsTo(Jip::class, 'jip_id');
    }
}
