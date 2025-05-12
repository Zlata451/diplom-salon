<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class AutoCompletePastAppointments extends Command
{
    protected $signature = 'appointments:auto-complete';

    protected $description = 'Автоматично завершує записи, які залишилися в минулому без змін';

    public function handle()
    {
        $now = Carbon::now();

        $count = Appointment::where('status', 'заплановано')
            ->where(function($query) use ($now) {
                $query->where('date', '<', $now->toDateString())
                      ->orWhere(function($q) use ($now) {
                          $q->where('date', '=', $now->toDateString())
                            ->where('time', '<', $now->format('H:i:s'));
                      });
            })
            ->update(['status' => 'завершено']);

        $this->info("Оновлено {$count} записів як завершені.");
    }
}