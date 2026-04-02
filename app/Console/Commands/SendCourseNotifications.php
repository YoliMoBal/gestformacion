<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CourseAssignment;
use App\Notifications\CourseDeadlineNotification;
use Carbon\Carbon;

class SendCourseNotifications extends Command
{
    protected $signature = 'courses:send-notifications';
    protected $description = 'Enviar notificaciones de cursos próximos a vencer';

    public function handle()
    {
        $today = Carbon::today();

        $daysBefore = [7, 3, 1];

        foreach ($daysBefore as $days) {

            $targetDate = $today->copy()->addDays($days);

            $assignments = CourseAssignment::whereHas('courseCall', function ($query) use ($targetDate) {
                    $query->whereDate('end_date', $targetDate);
                })
                ->where('status', '!=', 'completed')
                ->with(['user', 'courseCall.course'])
                ->get();

            foreach ($assignments as $assignment) {

                if ($assignment->user && $assignment->user->email) {

                    $assignment->user->notify(
                        new CourseDeadlineNotification($assignment->courseCall)
                    );
                }
            }
        }

        $this->info('Notificaciones enviadas correctamente.');

        return Command::SUCCESS;
    }
}








