@extends('layouts.app')

@section('content')

<div class="container p-4">

    <h1>Listado de cursos</h1>

    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">
        Crear curso
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Título</th>
                <th>Tipo</th>
                <th>Inicio</th>
                <th>Fin</th>
                <th style="width:200px;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($courses as $course)
                <tr>
                    <td>{{ $course->title }}</td>
                    <td>{{ $course->type }}</td>
                    <td>{{ $course->start_date }}</td>
                    <td>{{ $course->end_date }}</td>
                    <td class="d-flex gap-2">

                        <a href="{{ route('courses.edit', $course->id) }}"
                           class="btn btn-sm btn-warning">
                            Editar
                        </a>

                        <form action="{{ route('courses.destroy', $course->id) }}"
                              method="POST">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-sm btn-danger">
                                Eliminar
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        No hay cursos creados
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection

