@extends('layouts.app')

@section('content')

<h1>Crear convocatoria</h1>

<a href="{{ route('course-calls.index') }}" class="btn btn-secondary mb-3">
    ← Volver
</a>

<form action="{{ route('course-calls.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Curso</label>
        <select name="course_id" class="form-select" required>
            <option value="">-- Selecciona un curso --</option>
            @foreach($courses as $course)
                <option value="{{ $course->id }}">
                    {{ $course->title }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha inicio</label>
        <input type="date" name="start_date" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Fecha fin</label>
        <input type="date" name="end_date" class="form-control">
    </div>


    <button type="submit" class="btn btn-success">
        Guardar convocatoria
    </button>
</form>

@endsection
