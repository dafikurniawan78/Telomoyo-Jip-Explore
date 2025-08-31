<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jip extends Model
{
    use HasFactory;

    protected $fillable = [
        'plat_nomor',
        'kapasitas',
        'driver',
        'status',
    ];
}
