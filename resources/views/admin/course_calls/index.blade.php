@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-calendar me-2"></i>Convocatorias</h1>
    <a href="{{ route('course-calls.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Crear convocatoria
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Avisar (días)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calls as $call)
                    <tr>
                        <td>{{ $call->course->title }}</td>
                        <td>
                            @if($call->course->type == 'presencial')
                                <span class="badge bg-success">Presencial</span>
                            @elseif($call->course->type == 'e-learning')
                                <span class="badge bg-info text-dark">E-learning</span>
                            @else
                                <span class="badge bg-primary">Virtual</span>
                            @endif
                        </td>
                        <td>{{ $call->start_date }}</td>
                        <td>
                            @if($call->end_date < now()->format('Y-m-d'))
                                <span class="text-danger fw-bold"><i class="fas fa-exclamation-circle me-1"></i>{{ $call->end_date }}</span>
                            @else
                                {{ $call->end_date }}
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">{{ $call->notify_days_before }} días</span></td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('course-calls.edit', $call) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <form action="{{ route('course-calls.destroy', $call) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('¿Eliminar esta convocatoria?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-calendar me-2"></i>No hay convocatorias creadas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
