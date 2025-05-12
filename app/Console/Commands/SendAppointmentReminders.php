<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendAppointmentReminders extends Command
{
    protected $signature = 'appointments:send-reminders';
    protected $description = 'Надсилає email-нагадування клієнтам за день до запису';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->format('Y-m-d');

        $appointments = Appointment::with('user', 'service', 'master')
            ->where('date', $tomorrow)
            ->where('status', 'заплановано')
            ->get();

        foreach ($appointments as $appointment) {
            if ($appointment->user && $appointment->user->email) {
                $appointment->user->notify(new AppointmentReminderNotification($appointment));
            }
        }

        $this->info("Нагадування надіслано для {$appointments->count()} записів.");
    }
}
