<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCall;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        $course = Course::findOrFail($request->course_id);
        $tipo = $course->type;

        if ($tipo === 'e-learning') {
            $request->validate([
                'course_id'  => 'required|exists:courses,id',
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);

            CourseCall::create([
                'course_id'          => $request->course_id,
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);

        } elseif ($tipo === 'presencial') {
            $request->validate([
                'course_id'          => 'required|exists:courses,id',
                'fecha_curso'        => 'required|date',
                'hora_inicio_manana' => 'required',
                'hora_fin_manana'    => 'required',
                'duracion_dias'      => 'required|integer|min:1',
                'ubicacion_curso'    => 'nullable|string',
            ]);

            $fechaInicio = Carbon::parse($request->fecha_curso);
            $fechaFin = $fechaInicio->copy();
            $diasHabiles = 0;
            while ($diasHabiles < $request->duracion_dias - 1) {
                $fechaFin->addDay();
                if (!$fechaFin->isWeekend()) $diasHabiles++;
            }

            CourseCall::create([
                'course_id'          => $request->course_id,
                'start_date'         => $fechaInicio->toDateString(),
                'end_date'           => $fechaFin->toDateString(),
                'fecha_curso'        => $request->fecha_curso,
                'hora'               => $request->hora_inicio_manana,
                'hora_fin'           => $request->hora_fin_manana,
                'hora_inicio_tarde'  => $request->hora_inicio_tarde,
                'hora_fin_tarde'     => $request->hora_fin_tarde,
                'duracion_dias'      => $request->duracion_dias,
                'ubicacion_curso'    => $request->ubicacion_curso,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);

        } elseif ($tipo === 'virtual') {
            $request->validate([
                'course_id'      => 'required|exists:courses,id',
                'fecha_curso_virtual' => 'required|date',
                'hora'           => 'required',
                'hora_fin'       => 'required',
                'duracion_horas' => 'required|numeric|min:0.5',
            ]);

            CourseCall::create([
                'course_id'          => $request->course_id,
                'start_date'         => $request->fecha_curso_virtual,
                'end_date'           => $request->fecha_curso_virtual,
                'fecha_curso'        => $request->fecha_curso_virtual,
                'hora'               => $request->hora,
                'hora_fin'           => $request->hora_fin,
                'duracion_horas'     => $request->duracion_horas,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);
        }

        return redirect()->route('course-calls.index')
            ->with('success', 'Convocatoria creada correctamente');
    }

    private function getNotifyDays(Request $request)
    {
        $tipo = $request->tipo_aviso;
        if ($tipo === 'no') return 0;
        if ($tipo === 'custom') return $request->notify_days_before ?? 7;
        return 7;
    }

    public function edit(CourseCall $courseCall)
    {
        $courses = Course::orderBy('title')->get();
        return view('admin.course_calls.edit', compact('courseCall', 'courses'));
    }

    public function update(Request $request, CourseCall $courseCall)
    {
        $course = Course::findOrFail($request->course_id);
        $tipo = $course->type;

        if ($tipo === 'e-learning') {
            $request->validate([
                'course_id'  => 'required|exists:courses,id',
                'start_date' => 'required|date',
                'end_date'   => 'required|date|after_or_equal:start_date',
            ]);

            $courseCall->update([
                'course_id'          => $request->course_id,
                'start_date'         => $request->start_date,
                'end_date'           => $request->end_date,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);

        } elseif ($tipo === 'presencial') {
            $request->validate([
                'course_id'          => 'required|exists:courses,id',
                'fecha_curso'        => 'required|date',
                'hora_inicio_manana' => 'required',
                'hora_fin_manana'    => 'required',
                'duracion_dias'      => 'required|integer|min:1',
                'ubicacion_curso'    => 'nullable|string',
            ]);

            $fechaInicio = Carbon::parse($request->fecha_curso);
            $fechaFin = $fechaInicio->copy();
            $diasHabiles = 0;
            while ($diasHabiles < $request->duracion_dias - 1) {
                $fechaFin->addDay();
                if (!$fechaFin->isWeekend()) $diasHabiles++;
            }

            $courseCall->update([
                'course_id'          => $request->course_id,
                'start_date'         => $fechaInicio->toDateString(),
                'end_date'           => $fechaFin->toDateString(),
                'fecha_curso'        => $request->fecha_curso,
                'hora'               => $request->hora_inicio_manana,
                'hora_fin'           => $request->hora_fin_manana,
                'hora_inicio_tarde'  => $request->hora_inicio_tarde,
                'hora_fin_tarde'     => $request->hora_fin_tarde,
                'duracion_dias'      => $request->duracion_dias,
                'ubicacion_curso'    => $request->ubicacion_curso,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);

        } elseif ($tipo === 'virtual') {
            $request->validate([
                'course_id'           => 'required|exists:courses,id',
                'fecha_curso_virtual' => 'required|date',
                'hora'                => 'required',
                'hora_fin'            => 'required',
                'duracion_horas'      => 'required|numeric|min:0.5',
            ]);

            $courseCall->update([
                'course_id'          => $request->course_id,
                'start_date'         => $request->fecha_curso_virtual,
                'end_date'           => $request->fecha_curso_virtual,
                'fecha_curso'        => $request->fecha_curso_virtual,
                'hora'               => $request->hora,
                'hora_fin'           => $request->hora_fin,
                'duracion_horas'     => $request->duracion_horas,
                'notify_days_before' => $this->getNotifyDays($request),
            ]);
        }

        return redirect()->route('course-calls.index')
            ->with('success', 'Convocatoria actualizada correctamente');
    }

    public function destroy(CourseCall $courseCall)
    {
        $courseCall->delete();
        return redirect()->route('course-calls.index')
            ->with('success', 'Convocatoria eliminada correctamente');
    }
}