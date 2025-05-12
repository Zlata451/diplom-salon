<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentUpdatedForMasterNotification extends Notification
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
            ->subject('Оновлено запис клієнта')
            ->greeting("Привіт, {$notifiable->name}!")
            ->line("Запис клієнта було оновлено.")
            ->line("Послуга: {$this->appointment->service->name}")
            ->line("Клієнт: {$this->appointment->user->name}")
            ->line("Нова дата: {$this->appointment->date}")
            ->line("Новий час: {$this->appointment->time}")
            ->line("Статус: {$this->appointment->status}")
            ->line('Будь ласка, перевірте деталі у вашому кабінеті.');
    }
}
