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
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $course = $this->courseCall->course;
        $tipo = $course->type;

        if ($tipo === 'e-learning') {
            $diasRestantes = Carbon::today()->diffInDays(Carbon::parse($this->courseCall->end_date));

            return (new MailMessage)
                ->subject('⏰ Recordatorio de formación: ' . $course->title)
                ->greeting('Hola, ' . $notifiable->name . '!')
                ->line('Te recordamos que tienes un curso e-learning pendiente de completar.')
                ->line('**Curso:** ' . $course->title)
                ->line('**Fecha inicio:** ' . Carbon::parse($this->courseCall->start_date)->format('d/m/Y'))
                ->line('**Fecha límite:** ' . Carbon::parse($this->courseCall->end_date)->format('d/m/Y'))
                ->line('⚠️ Te quedan **' . $diasRestantes . ' días** para completarlo.')
                ->line('Por favor, completa la formación antes de la fecha límite.')
                ->salutation('Un saludo, GestFormación — Rombosol');

        } elseif ($tipo === 'presencial') {
            $fecha = Carbon::parse($this->courseCall->fecha_curso ?? $this->courseCall->start_date);
            $horaInicio = $this->courseCall->hora ? Carbon::parse($this->courseCall->hora)->format('H:i') : '';
            $horaFin = $this->courseCall->hora_fin ? Carbon::parse($this->courseCall->hora_fin)->format('H:i') : '';
            $horaInicioTarde = $this->courseCall->hora_inicio_tarde ? Carbon::parse($this->courseCall->hora_inicio_tarde)->format('H:i') : '';
            $horaFinTarde = $this->courseCall->hora_fin_tarde ? Carbon::parse($this->courseCall->hora_fin_tarde)->format('H:i') : '';

            $horario = $horaInicio && $horaFin ? $horaInicio . ' - ' . $horaFin : '';
            if ($horaInicioTarde && $horaFinTarde) {
                $horario .= ' y ' . $horaInicioTarde . ' - ' . $horaFinTarde;
            }

            $mail = (new MailMessage)
                ->subject('⏰ Recordatorio de formación presencial: ' . $course->title)
                ->greeting('Hola, ' . $notifiable->name . '!')
                ->line('Te recordamos que tienes una formación presencial próxima.')
                ->line('**Curso:** ' . $course->title)
                ->line('**Fecha:** ' . $fecha->format('d/m/Y') . ' (' . $fecha->locale('es')->dayName . ')');

            if ($horario) {
                $mail->line('**Horario:** ' . $horario);
            }
            if ($this->courseCall->duracion_dias > 1) {
                $mail->line('**Duración:** ' . $this->courseCall->duracion_dias . ' días');
                $mail->line('**Fecha fin:** ' . Carbon::parse($this->courseCall->end_date)->format('d/m/Y'));
            }
            if ($this->courseCall->ubicacion_curso) {
                $mail->line('**Ubicación:** ' . $this->courseCall->ubicacion_curso);
            }

            $mail->line('Por favor, confirma tu asistencia con tu responsable.')
                ->salutation('Un saludo, GestFormación — Rombosol');

            return $mail;

        } elseif ($tipo === 'virtual') {
            $fecha = Carbon::parse($this->courseCall->fecha_curso ?? $this->courseCall->start_date);
            $horaInicio = $this->courseCall->hora ? Carbon::parse($this->courseCall->hora)->format('H:i') : '';
            $horaFin = $this->courseCall->hora_fin ? Carbon::parse($this->courseCall->hora_fin)->format('H:i') : '';

            $mail = (new MailMessage)
                ->subject('⏰ Recordatorio de formación virtual: ' . $course->title)
                ->greeting('Hola, ' . $notifiable->name . '!')
                ->line('Te recordamos que tienes una formación virtual próxima.')
                ->line('**Curso:** ' . $course->title)
                ->line('**Fecha:** ' . $fecha->format('d/m/Y') . ' (' . $fecha->locale('es')->dayName . ')');

            if ($horaInicio && $horaFin) {
                $mail->line('**Horario:** ' . $horaInicio . ' - ' . $horaFin);
            }
            if ($this->courseCall->duracion_horas) {
                $mail->line('**Duración:** ' . $this->courseCall->duracion_horas . ' horas');
            }

            $mail->line('Recibirás el enlace de acceso antes del inicio de la sesión.')
                ->salutation('Un saludo, GestFormación — Rombosol');

            return $mail;
        }

        return (new MailMessage)
            ->subject('⏰ Recordatorio de formación: ' . $course->title)
            ->greeting('Hola, ' . $notifiable->name . '!')
            ->line('Tienes una formación pendiente: **' . $course->title . '**')
            ->salutation('Un saludo, GestFormación — Rombosol');
    }

    public function toArray($notifiable)
    {
        $course = $this->courseCall->course;
        return [
            'title' => 'Recordatorio: ' . $course->title,
            'message' => 'Tienes formación pendiente: ' . $course->title,
            'course_call_id' => $this->courseCall->id,
        ];
    }
}





