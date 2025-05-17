<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Notifications\AppointmentReminderNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Carbon;

class AppointmentToolsController extends Controller
{
    public function sendReminders()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $appointments = Appointment::with('user')
            ->where('status', 'заплановано')
            ->where('date', $tomorrow)
            ->get();

        foreach ($appointments as $appointment) {
            if ($appointment->user && $appointment->user->email) {
                Notification::route('mail', $appointment->user->email)
                    ->notify(new AppointmentReminderNotification($appointment));
            }
        }

        return redirect()->route('appointments.index')->with('success', 'Нагадування успішно надіслано!');
    }

    public function updateStatuses()
    {
        $now = Carbon::now();
        $today = $now->toDateString();

        Appointment::where('status', 'заплановано')
            ->where(function ($query) use ($today, $now) {
                $query->where('date', '<', $today)
                      ->orWhere(function ($q) use ($today, $now) {
                          $q->where('date', $today)->where('time', '<', $now->format('H:i'));
                      });
            })
            ->update(['status' => 'завершено']);

        return redirect()->route('appointments.index')->with('success', 'Статуси оновлено!');
    }
}
