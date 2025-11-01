<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;
use App\Services\FCFSService;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->call(function () {
            $fcfs = app(FCFSService::class);

            $fcfs->updateAntreanSelesaiOtomatis();
            $fcfs->prosesAntrean();
        })->everyMinute()
            ->appendOutputTo(storage_path('logs/fcfs.log'));
    })
    ->create();
