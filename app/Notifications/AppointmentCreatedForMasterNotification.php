<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentCreatedForMasterNotification extends Notification
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
            ->subject('Нове бронювання клієнта')
            ->greeting("Вітаємо, {$notifiable->name}!")
            ->line("У вас новий запис від клієнта: {$this->appointment->user->name}")
            ->line("Послуга: {$this->appointment->service->name}")
            ->line("Дата: {$this->appointment->date}")
            ->line("Час: {$this->appointment->time}")
            ->line("Не забудьте підготуватися до зустрічі!");
    }
}
