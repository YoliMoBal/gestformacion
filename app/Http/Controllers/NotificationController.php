<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseAssignment;
use App\Notifications\CourseDeadlineNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // LISTAR NOTIFICACIONES ADMIN
    public function index()
    {
        $notifications = Auth::user()->notifications()->latest()->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    // MARCAR COMO LEÍDA
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('success', 'Notificación marcada como leída');
    }

    // 🔥 ENVÍO MANUAL DESDE PANEL ADMIN
    public function sendCourseNotifications()
    {
        $limitDate = Carbon::now()->addDays(7);

        $assignments = CourseAssignment::whereHas('course', function ($q) use ($limitDate) {
            $q->whereDate('end_date', '<=', $limitDate);
        })->where('status', '!=', 'completed')->get();

        foreach ($assignments as $assignment) {
            $assignment->user->notify(
                new CourseDeadlineNotification($assignment->course)
            );
        }

        return back()->with('success', 'Notificaciones enviadas manualmente');
    }
}




