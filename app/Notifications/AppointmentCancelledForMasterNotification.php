<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCancelledForMasterNotification extends Notification
{
    use Queueable;

    public Appointment $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Запис скасовано')
            ->greeting("Вітаємо, {$notifiable->name}!")
            ->line("Клієнт скасував запис на послугу: \"{$this->appointment->service->name}\".")
            ->line("Дата: {$this->appointment->date}")
            ->line("Час: {$this->appointment->time}")
            ->line("Клієнт: {$this->appointment->user->name}")
            ->line("Перевірте оновлений розклад у панелі адміністратора.");
    }
}
