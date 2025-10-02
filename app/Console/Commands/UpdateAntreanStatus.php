<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Antrean;
use Carbon\Carbon;

class UpdateAntreanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'antrean:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status antrean otomatis ke selesai jika sudah lewat waktu';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $update = Antrean::where('status', 'sedang dilayani')->where('waktu_selesai', '<', $now)->update(['status' => 'selesai']);

        $this->info("Update $update antrean ke selesai.");
    }
}
