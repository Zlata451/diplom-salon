<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCanceledNotification extends Notification
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
            ->subject('Ваш запис скасовано')
            ->greeting("Привіт, {$notifiable->name}!")
            ->line("Ваш запис на послугу \"{$this->appointment->service->name}\" було скасовано.")
            ->line("Дата: {$this->appointment->date}")
            ->line("Час: {$this->appointment->time}")
            ->line("Майстер: {$this->appointment->master->name}")
            ->line('Якщо це сталося помилково — ви можете створити новий запис у будь-який момент.');
    }
}
