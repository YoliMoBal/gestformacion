<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class CourseDeadlineNotification extends Notification
{
    use Queueable;

    protected $courseCall;

    public function __construct($courseCall)
    {
        $this->courseCall = $courseCall;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $course = $this->courseCall->course;

        return (new MailMessage)
            ->subject('Recordatorio de curso: ' . $course->title)
            ->greeting('Hola ' . $notifiable->name)
            ->line('El curso "' . $course->title . '" está próximo a finalizar.')
            ->line('Fecha inicio: ' . Carbon::parse($this->courseCall->start_date)->format('d/m/Y'))
            ->line('Fecha fin: ' . Carbon::parse($this->courseCall->end_date)->format('d/m/Y'))
            ->line('Este es un aviso automático del sistema de formación.')
            ->salutation('Formación Rombosol');
    }
}






