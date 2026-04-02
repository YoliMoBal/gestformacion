@extends('layouts.app')

@section('content')

<h1>Convocatorias</h1>

<a href="{{ route('course-calls.create') }}" class="btn btn-primary mb-3">
    Crear convocatoria
</a>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Avisar X días antes</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($calls as $call)
            <tr>
                <td>{{ $call->course->title }}</td>
                <td>{{ $call->start_date }}</td>
                <td>{{ $call->end_date }}</td>
                <td>{{ $call->notify_days_before }}</td>
                <td>
                    <a href="{{ route('course-calls.edit', $call) }}"
                        class="btn btn-warning btn-sm">
                        Editar
                    </a>

                <form action="{{ route('course-calls.destroy', $call) }}"
                    method="POST"
                    class="d-inline"
                    onsubmit="return confirm('¿Seguro que quieres eliminar esta convocatoria?')">
                    @csrf
                    @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    Eliminar
                </button>
                </form>
                </td>

            </tr>
        @endforeach
    </tbody>
</table>

@endsection
