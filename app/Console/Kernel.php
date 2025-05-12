<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Зареєстровані Artisan-команди
     */
    protected $commands = [
        \App\Console\Commands\AutoCompletePastAppointments::class,
    ];

    /**
     * Розклад виконання команд
     */
    protected function schedule(Schedule $schedule): void
    {
        // ⏰ Надсилання нагадувань щодня о 08:00
        $schedule->command('appointments:send-reminders')->dailyAt('08:00');

        // ✅ Автоматичне завершення записів щодня о 01:00
        $schedule->command('appointments:complete-past')->dailyAt('01:00');
    }

    /**
     * Реєстрація команд
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}