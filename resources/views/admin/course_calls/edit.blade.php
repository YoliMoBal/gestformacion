@extends('layouts.app')

@section('content')

<h1>Editar convocatoria</h1>

<a href="{{ route('course-calls.index') }}" class="btn btn-secondary mb-3">
    ← Volver
</a>

<form action="{{ route('course-calls.update', $courseCall) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Curso</label>
        <select name="course_id" class="form-select" required>
            @foreach($courses as $course)
                <option value="{{ $course->id }}"
                    @selected($courseCall->course_id === $course->id)>
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha inicio</label>
        <input type="date"
               name="start_date"
               class="form-control"
               value="{{ $courseCall->start_date }}"
               required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha fin</label>
        <input type="date"
               name="end_date"
               class="form-control"
               value="{{ $courseCall->end_date }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Avisar X días antes</label>
        <input type="number"
               name="notify_days_before"
               class="form-control"
               value="{{ $courseCall->notify_days_before }}"
               min="0">
    </div>

    <div class="form-check mb-2">
        <input class="form-check-input"
               type="checkbox"
               name="notify_on_start"
               value="1"
               @checked($courseCall->notify_on_start)>
        <label class="form-check-label">Avisar el día de inicio</label>
    </div>

    <div class="form-check mb-3">
        <input class="form-check-input"
               type="checkbox"
               name="notify_on_end"
               value="1"
               @checked($courseCall->notify_on_end)>
        <label class="form-check-label">Avisar al finalizar</label>
    </div>

    <button type="submit" class="btn btn-success">
        Guardar cambios
    </button>
</form>

@endsection
