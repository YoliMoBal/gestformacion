@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-tasks me-2"></i>Asignaciones</h1>
    <a href="{{ route('assignments.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Asignar curso
    </a>
</div>

<!-- FILTROS -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar empleado</label>
                <input type="text" name="search" class="form-control"
                    placeholder="Nombre del empleado..." value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Empleado</label>
                <select name="user_id" class="form-select">
                    <option value="">Todos los empleados</option>
                    @foreach($employees as $employee)
                        <option value="{{ $employee->id }}"
                            {{ request('user_id') == $employee->id ? 'selected' : '' }}>
                            {{ $employee->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('assignments.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- LEYENDA -->
<div class="d-flex gap-3 mb-3 align-items-center">
    <small class="text-muted fw-bold">Leyenda:</small>
    <span style="background:#d1fae5; color:#065f46; padding:4px 12px; border-radius:20px; font-size:0.85rem; font-weight:600;">✅ Completado</span>
    <span style="background:#fef3c7; color:#92400e; padding:4px 12px; border-radius:20px; font-size:0.85rem; font-weight:600;">⚠️ Próximo a vencer (7 días)</span>
    <span style="background:#fce7f3; color:#9d174d; padding:4px 12px; border-radius:20px; font-size:0.85rem; font-weight:600;">🔴 Caducado</span>
</div>

<!-- TABLA -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Curso</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assignments as $a)
                    @php
                        $call = $a->courseCall;
                        $course = optional($call)->course;
                        $caducado = $call && $call->end_date &&
                            \Carbon\Carbon::parse($call->end_date)->lt(now()) &&
                            $a->status != 'completed';
                        $urgente = $call && $call->end_date &&
                            \Carbon\Carbon::parse($call->end_date)->gte(now()) &&
                            \Carbon\Carbon::parse($call->end_date)->lte(now()->addDays(7)) &&
                            $a->status != 'completed';
                    @endphp
                    <tr class="{{ $a->status == 'completed' ? 'table-success' : ($caducado ? 'table-danger' : ($urgente ? 'table-warning' : '')) }}">
                        <td><i class="fas fa-user me-2 text-muted"></i>{{ $a->user->name }}</td>
                        <td>{{ $course?->title ?? '-' }}</td>
                        <td>{{ $call?->start_date ?? '-' }}</td>
                        <td>
                            @if($caducado)
                                <span class="text-danger fw-bold">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $call->end_date }}
                                </span>
                            @elseif($urgente)
                                <span class="fw-bold" style="color:#92400e;">
                                    <i class="fas fa-clock me-1"></i>{{ $call->end_date }}
                                </span>
                            @else
                                {{ $call?->end_date ?? '-' }}
                            @endif
                        </td>
                        <td>
                            @if($a->status == 'pending')
                                <span class="badge-pending">Pendiente</span>
                            @elseif($a->status == 'in_progress')
                                <span class="badge-progress">En curso</span>
                            @else
                                <span class="badge-completed">Completado</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('assignments.edit', $a->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <form action="{{ route('assignments.destroy', $a->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger me-1">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </form>
                            @if($a->status != 'completed')
                                <form action="{{ route('assignments.notify', $a->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-bell me-1"></i>Notificar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-tasks me-2"></i>No hay asignaciones
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection