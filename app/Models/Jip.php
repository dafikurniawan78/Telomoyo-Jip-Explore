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

    public function alokasiJip()
    {
        return $this->hasMany(AlokasiJip::class);
    }
}
