@extends('layouts.app')

@section('content')

<div class="container p-4">

<h1 class="mb-3">Asignaciones de Cursos</h1>

<a href="{{ route('assignments.create') }}" class="btn btn-primary mb-3">
    Asignar curso
</a>

<form method="GET" class="mb-4 d-flex flex-wrap gap-2 align-items-end">

    <input type="text"
           name="search"
           class="form-control w-auto"
           placeholder="Buscar empleado..."
           value="{{ request('search') }}">

    <select name="user_id" class="form-select w-auto">
        <option value="">— Todos los empleados —</option>
        @foreach($employees as $employee)
            <option value="{{ $employee->id }}"
                {{ request('user_id') == $employee->id ? 'selected' : '' }}>
                {{ $employee->name }}
            </option>
        @endforeach
    </select>

    <button class="btn btn-secondary">Filtrar</button>

    <a href="{{ route('assignments.index') }}" class="btn btn-outline-secondary">
        Limpiar
    </a>
</form>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>Empleado</th>
            <th>Curso</th>
            <th>Inicio</th>
            <th>Fin</th>
            <th>Estado</th>
            <th style="width: 220px;">Acciones</th>
        </tr>
    </thead>

    <tbody>
    @forelse($assignments as $a)

        @php
            $call = $a->courseCall;
            $course = optional($call)->course;
        @endphp

        <tr
            @if(
                $call &&
                $call->end_date &&
                \Carbon\Carbon::parse($call->end_date)
                    ->lte(\Carbon\Carbon::now()->addDays(7)) &&
                $a->status != 'completed'
            )
                class="table-warning"
            @endif
        >
            <td>{{ $a->user->name }}</td>

            <td>{{ $course?->title ?? '-' }}</td>

            <td>{{ $call?->start_date ?? '-' }}</td>

            <td>{{ $call?->end_date ?? '-' }}</td>

            <td>
                @if($a->status == 'pending')
                    <span class="badge bg-danger">Pendiente</span>
                @elseif($a->status == 'in_progress')
                    <span class="badge bg-warning text-dark">En progreso</span>
                @else
                    <span class="badge bg-success">Completado</span>
                @endif
            </td>

            <td class="d-flex gap-2">

                <a href="{{ route('assignments.edit', $a->id) }}"
                   class="btn btn-sm btn-warning">
                    Editar
                </a>

                <form action="{{ route('assignments.destroy', $a->id) }}"
                      method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">
                        Eliminar
                    </button>
                </form>

                @if($a->status != 'completed')
                    <form action="{{ route('assignments.notify', $a->id) }}"
                          method="POST">
                        @csrf
                        <button class="btn btn-sm btn-info text-white">
                            Notificar
                        </button>
                    </form>
                @endif

            </td>
        </tr>

    @empty
        <tr>
            <td colspan="6" class="text-center">No hay asignaciones</td>
        </tr>
    @endforelse
    </tbody>
</table>

</div>

@endsection



