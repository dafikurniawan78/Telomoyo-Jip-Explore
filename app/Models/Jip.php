<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Jip extends Model
{
    use HasFactory;

    protected $table = 'jips';

    protected $fillable = [
        'plat_nomor',
        'kapasitas',
        'driver',
        'status',
        'last_used_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi: semua alokasi jip
    public function alokasiJip()
    {
        return $this->hasMany(AlokasiJip::class, 'jip_id', 'id');
    }

    public function alokasiJipAktif()
    {
        $now = Carbon::now('Asia/Jakarta');
        return $this->hasOne(AlokasiJip::class, 'jip_id', 'id')
            ->where('waktu_mulai', '<=', $now)
            ->where('waktu_selesai', '>=', $now);
    }

    public function tandaiDigunakan()
    {
        DB::table('jips')
            ->where('id', $this->id)
            ->update(['status' => 'digunakan', 'updated_at' => now()]);

        $this->refresh();
    }

    public function tandaiTersedia()
    {
        DB::table('jips')
            ->where('id', $this->id)
            ->update([
                'status' => 'tersedia',
                'updated_at' => now(),
                'last_used_at' => now(),
            ]);

        $this->refresh();
    }

    public function sedangDigunakan()
    {
        if ($this->status !== 'digunakan') {
            return false;
        }

        return $this->alokasiJipAktif()->exists();
    }
}
