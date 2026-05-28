<?php

namespace App\Http\Controllers;

use App\Models\CourseAssignment;
use App\Models\User;
use App\Models\CourseCall;
use Illuminate\Http\Request;
use App\Notifications\CourseDeadlineNotification;

class CourseAssignmentController extends Controller
{
    public function index()
    {
        $userId = request('user_id');
        $search = request('search');
        $searchCourse = request('search_course');
        $estado = request('estado');

        $base = CourseAssignment::with(['user', 'courseCall.course'])
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when($search, fn($q) => $q->whereHas('user', fn($q2) =>
                $q2->where('name', 'like', '%' . $search . '%')))
            ->when($searchCourse, fn($q) => $q->whereHas('courseCall.course', fn($q2) =>
                $q2->where('title', 'like', '%' . $searchCourse . '%')))
            ->when($estado, fn($q) => $q->where('status', $estado));

        // Completados
        $completados = (clone $base)
            ->where('status', 'completed')
            ->get()->sortByDesc(fn($a) => $a->courseCall->end_date);

        // Pendientes sin caducar
        $pendientes = (clone $base)
            ->where('status', '!=', 'completed')
            ->whereHas('courseCall', fn($q) => $q->whereDate('end_date', '>=', now()))
            ->get()->sortBy(fn($a) => $a->courseCall->end_date);

        // Caducados
        $caducados = (clone $base)
            ->where('status', '!=', 'completed')
            ->whereHas('courseCall', fn($q) => $q->whereDate('end_date', '<', now()))
            ->get()->sortBy(fn($a) => $a->courseCall->end_date);

        $assignments = $pendientes->concat($caducados)->concat($completados);

        $employees = User::orderBy('name')->get();

        return view('admin.assignments.index', compact('assignments', 'employees'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $calls = CourseCall::with('course')->orderBy('start_date')->get();

        return view('admin.assignments.create', compact('users', 'calls'));
    }

    public function edit($id)
    {
        $assignment = CourseAssignment::with('user', 'courseCall.course')
            ->findOrFail($id);

        return view('admin.assignments.edit', compact('assignment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'        => 'required|exists:users,id',
            'course_call_id' => 'required|exists:course_calls,id',
            'status'         => 'required|in:pending,in_progress,completed',
        ]);

        CourseAssignment::create($request->only([
            'user_id',
            'course_call_id',
            'status'
        ]));

        return redirect()->route('assignments.index')
            ->with('success', 'Convocatoria asignada correctamente');
    }

    public function update(Request $request, $id)
    {
        $assignment = CourseAssignment::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed'
        ]);

        $assignment->update([
            'status' => $request->status
        ]);

        return redirect()->route('assignments.index')
            ->with('success', 'Estado actualizado');
    }

    public function notify($id)
    {
        $assignment = CourseAssignment::with(['user', 'courseCall.course'])
            ->findOrFail($id);

        $assignment->user->notify(
            new CourseDeadlineNotification($assignment->courseCall)
        );

        return redirect()->back()
            ->with('success', 'Notificación enviada al empleado');
    }

    public function destroy($id)
    {
        CourseAssignment::destroy($id);

        return redirect()->route('assignments.index')
            ->with('success', 'Asignación eliminada');
    }
}
