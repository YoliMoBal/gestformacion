@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-history me-2"></i>Histórico de cursos</h1>

<!-- FILTROS -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar curso</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nombre del curso" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipo de curso</label>
                <select name="type" class="form-select">
                    <option value="">Todos</option>
                    <option value="presencial" {{ request('type') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                    <option value="e-learning" {{ request('type') == 'e-learning' ? 'selected' : '' }}>E-learning</option>
                    <option value="virtual" {{ request('type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('dashboard.history') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- TABLA HISTÓRICO -->
<div class="card">
    <div class="card-header-custom">
        <i class="fas fa-check-circle me-2"></i>Cursos completados
        <span class="badge bg-success ms-2">{{ $completedAssignments->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($completedAssignments->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-book me-2 text-muted" style="font-size: 2rem;"></i>
                <p class="text-muted mt-2">Aún no has completado cursos.</p>
            </div>
        @else
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Curso</th>
                        <th>Tipo</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAssignments as $a)
                        <tr>
                            <td style="font-size: 1rem;">{{ $a->courseCall->course->title }}</td>
                            <td>
                                @if($a->courseCall->course->type == 'presencial')
                                    <span class="badge bg-success" style="font-size: 0.95rem; padding: 6px 14px;">Presencial</span>
                                @elseif($a->courseCall->course->type == 'e-learning')
                                    <span class="badge bg-info text-dark" style="font-size: 0.95rem; padding: 6px 14px;">E-learning</span>
                                @else
                                    <span class="badge bg-primary" style="font-size: 0.95rem; padding: 6px 14px;">Virtual</span>
                                @endif
                            </td>
                            <td style="font-size: 1rem;">{{ \Carbon\Carbon::parse($a->courseCall->start_date)->format('d/m/Y') }}</td>
                            <td style="font-size: 1rem;">{{ \Carbon\Carbon::parse($a->courseCall->end_date)->format('d/m/Y') }}</td>
                            <td><span class="badge-completed" style="font-size: 0.95rem; padding: 6px 14px;"><i class="fas fa-check me-1"></i>Completado</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@endsection