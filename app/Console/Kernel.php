<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Registrar comandos Artisan.
     */
    protected $commands = [
        \App\Console\Commands\SendCourseNotifications::class,
    ];

    /**
     * Definir el scheduler.
     */
    protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
    {
    $schedule->command('courses:send-notifications')->dailyAt('08:00');
    }


    /**
     * Registrar comandos del sistema.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        // ⚠️ ESTO ES LO QUE FALTABA
        require base_path('routes/console.php');
    }
    protected $middlewareAliases = [
    'auth' => \Illuminate\Auth\Middleware\Authenticate::class,
    'admin' => \App\Http\Middleware\AdminMiddleware::class,
];

}



