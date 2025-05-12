<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCreatedNotification extends Notification
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
            ->subject('Підтвердження запису')
            ->greeting("Привіт, {$notifiable->name}!")
            ->line("Ви успішно записались на послугу \"{$this->appointment->service->name}\".")
            ->line("Дата: {$this->appointment->date}")
            ->line("Час: {$this->appointment->time}")
            ->line("Майстер: {$this->appointment->master->name}")
            ->line('Чекаємо вас у салоні!');
    }
}
