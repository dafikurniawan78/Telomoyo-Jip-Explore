<?php

use App\Services\FCFSService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Jalankan FCFS otomatis setiap menit
Schedule::call(function () {
    $fcfs = app(FCFSService::class);
    $fcfs->updateAntreanSelesaiOtomatis();
    $fcfs->prosesAntrean();
})->everyMinute();
