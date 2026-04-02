
@extends('layouts.app')


@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <h1>Crear nuevo curso</h1>

    <a href="{{ route('courses.index') }}" class="btn btn-secondary mb-3">
        ← Volver
    </a>

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Título del curso</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
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

        <div class="mb-3">
            <label class="form-label">Fecha inicio</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha fin</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">
            Guardar curso
        </button>
    </form>

</body>
@endsection
