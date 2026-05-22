<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'type' => 'required',
        ]);

        Course::create([
    'title' => $request->title,
    'description' => $request->description,
    'type' => $request->type,
]);

        return redirect()->route('courses.index')
            ->with('success', 'Curso creado correctamente');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
]);

        return redirect()->route('courses.index')
            ->with('success', 'Curso actualizado');
    }

    public function destroy($id)
    {
        Course::destroy($id);

        return redirect()->route('courses.index')
            ->with('success', 'Curso eliminado');
    }
}
