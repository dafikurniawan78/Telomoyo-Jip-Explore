<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaketWisata extends Model
{
    use HasFactory;

    protected $fillable = ['nama_paket', 'durasi', 'harga', 'deskripsi'];
}
