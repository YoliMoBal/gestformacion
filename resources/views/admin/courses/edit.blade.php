@extends('layouts.app')

@section('content')

<div class="container p-4">

    <h1>Editar curso</h1>

    <a href="{{ route('courses.index') }}" class="btn btn-secondary mb-3">
        ← Volver
    </a>

    <form action="{{ route('courses.update', $course->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="title" class="form-control"
                   value="{{ $course->title }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control">{{ $course->description }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="type" class="form-select" required>
                <option value="presencial" {{ $course->type == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="e-learning" {{ $course->type == 'e-learning' ? 'selected' : '' }}>E-learning</option>
                <option value="virtual" {{ $course->type == 'virtual' ? 'selected' : '' }}>Virtual</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha inicio</label>
            <input type="date" name="start_date" class="form-control"
                   value="{{ $course->start_date }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha fin</label>
            <input type="date" name="end_date" class="form-control"
                   value="{{ $course->end_date }}">
        </div>

        <button type="submit" class="btn btn-success">
            Guardar cambios
        </button>
    </form>

</div>

@endsection

