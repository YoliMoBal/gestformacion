<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCall;
use Illuminate\Http\Request;

class CourseCallController extends Controller
{
    public function index()
    {
        $calls = CourseCall::with('course')->latest()->get();

        return view('admin.course_calls.index', compact('calls'));
    }

    public function create()
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.course_calls.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notify_days_before' => 'nullable|integer|min:0',
            'notify_on_start' => 'nullable|boolean',
            'notify_on_end' => 'nullable|boolean',
        ]);

        CourseCall::create([
            'course_id' => $validated['course_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'notify_days_before' => $request->input('notify_days_before', 0),
            'notify_on_start' => $request->boolean('notify_on_start'),
            'notify_on_end' => $request->boolean('notify_on_end'),
        ]);

        return redirect()
            ->route('course-calls.index')
            ->with('success', 'Convocatoria creada correctamente');
    }

    public function edit(CourseCall $courseCall)
    {
        $courses = Course::orderBy('title')->get();

        return view('admin.course_calls.edit', compact('courseCall', 'courses'));
    }

    public function update(Request $request, CourseCall $courseCall)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'notify_days_before' => 'nullable|integer|min:0',
            'notify_on_start' => 'nullable|boolean',
            'notify_on_end' => 'nullable|boolean',
        ]);

        $courseCall->update([
            'course_id' => $validated['course_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
            'notify_days_before' => $request->input('notify_days_before', 0),
            'notify_on_start' => $request->boolean('notify_on_start'),
            'notify_on_end' => $request->boolean('notify_on_end'),
        ]);

        return redirect()
            ->route('course-calls.index')
            ->with('success', 'Convocatoria actualizada correctamente');
    }

    public function destroy(CourseCall $courseCall)
    {
        $courseCall->delete();

        return redirect()
            ->route('course-calls.index')
            ->with('success', 'Convocatoria eliminada correctamente');
    }
}
