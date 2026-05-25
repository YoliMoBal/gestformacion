@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-book me-2"></i>Editar curso</h1>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
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
                <textarea name="description" class="form-control" rows="3">{{ $course->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo</label>
                <select name="type" class="form-select" required>
                    <option value="presencial" {{ $course->type == 'presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="e-learning" {{ $course->type == 'e-learning' ? 'selected' : '' }}>E-learning</option>
                    <option value="virtual" {{ $course->type == 'virtual' ? 'selected' : '' }}>Virtual</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Guardar cambios
                </button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
