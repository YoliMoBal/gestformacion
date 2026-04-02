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
        $query = CourseAssignment::with(['user', 'courseCall.course']);

        // FILTRO POR EMPLEADO
        if (request('user_id')) {
            $query->where('user_id', request('user_id'));
        }

        // BÚSQUEDA POR NOMBRE
        if (request('search')) {
            $query->whereHas('user', function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            });
        }

        // ORDENAR POR FECHA FIN DE LA CONVOCATORIA
        $assignments = $query->get()->sortBy(function ($a) {
            return optional($a->courseCall)->end_date;
        });

        $employees = User::orderBy('name')->get();

        return view('admin.assignments.index', compact(
            'assignments',
            'employees'
        ));
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

    // Notificación manual desde admin
    public function notify($id)
    {
        $assignment = CourseAssignment::with(['user','courseCall.course'])
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

