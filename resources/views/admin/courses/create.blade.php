@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-book me-2"></i>Crear nuevo curso</h1>

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
        <form action="{{ route('courses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Título del curso</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo de curso</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Selecciona --</option>
                    <option value="presencial">Presencial</option>
                    <option value="e-learning">E-learning</option>
                    <option value="virtual">Virtual</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Guardar curso
                </button>
                <a href="{{ route('courses.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
