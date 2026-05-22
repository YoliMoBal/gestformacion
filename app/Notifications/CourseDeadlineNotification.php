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
        $diasRestantes = Carbon::today()->diffInDays(Carbon::parse($this->courseCall->end_date));

        return (new MailMessage)
            ->subject('⏰ Recordatorio de formación: ' . $course->title)
            ->greeting('Hola, ' . $notifiable->name . '!')
            ->line('Te recordamos que tienes un curso pendiente de completar.')
            ->line('**Curso:** ' . $course->title)
            ->line('**Tipo:** ' . ucfirst($course->type))
            ->line('**Fecha inicio:** ' . Carbon::parse($this->courseCall->start_date)->format('d/m/Y'))
            ->line('**Fecha límite:** ' . Carbon::parse($this->courseCall->end_date)->format('d/m/Y'))
            ->line('⚠️ Te quedan **' . $diasRestantes . ' días** para completarlo.')
            ->line('Por favor, completa la formación antes de la fecha límite.')
            ->salutation('Un saludo, GestFormación — Rombosol');
    }
}





