@extends('layouts.admin')

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

    <h1>Listado de cursos</h1>

    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">
        Crear curso
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->type }}</td>
                    <td>{{ $course->start_date }}</td>
                    <td>{{ $course->end_date }}</td>
                    <td>
                        <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
                            Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay cursos creados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
