<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentReminderNotification extends Notification
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
        $greetingName = method_exists($notifiable, 'getAttribute') && $notifiable->getAttribute('name')
            ? $notifiable->name
            : 'клієнте';

        return (new MailMessage)
            ->subject('Нагадування про запис')
            ->greeting("Привіт, {$greetingName}!")
            ->line("Нагадуємо, що ви маєте запис на послугу \"{$this->appointment->service->name}\".")
            ->line("Дата: {$this->appointment->date}")
            ->line("Час: {$this->appointment->time}")
            ->line("Майстер: {$this->appointment->master->name}")
            ->line('До зустрічі в салоні!');
    }
}
