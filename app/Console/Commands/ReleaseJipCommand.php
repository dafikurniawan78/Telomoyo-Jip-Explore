<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AlokasiJip;
use App\Models\Jip;
use Carbon\Carbon;

class ReleaseJipCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jip:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melepaskan jip yang sudah selesai digunakan agar kembali tersedia';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $alokasi = AlokasiJip::where('waktu_selesai', '<=', $now)->get();

        foreach ($alokasi as $a) {
            if ($a->jip) {
                $a->jip->update(['status' => 'tersedia']);
            }
        }

        $this->info('Semua jip yang sudah selesai dialokasikan kembali tersedia.');
    }
}
