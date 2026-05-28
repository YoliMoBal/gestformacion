@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-chart-line me-2"></i>Panel de Administración</h1>

<!-- BOTÓN ENVÍO -->
<div class="row g-3 mb-4">
    <div class="col-auto">
        <form action="{{ route('admin.sendCourseNotifications') }}" method="POST">
            @csrf
            <button class="btn btn-primary">
                <i class="fas fa-bell me-2"></i>Enviar notificaciones de vencimiento
            </button>
        </form>
    </div>
</div>

<!-- FILTROS -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar empleado</label>
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Nombre del empleado" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Empleado</label>
                <select name="user_id" class="form-select">
                    <option value="">Todos</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}"
                            {{ request('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary">
                    <i class="fas fa-search me-1"></i>Filtrar
                </button>
                <a href="{{ route('admin.panel') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-times me-1"></i>Limpiar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- CURSOS PRÓXIMOS A CADUCAR -->
<div class="card mb-4">
    <div class="card-header-custom">
        <i class="fas fa-exclamation-triangle me-2"></i>Cursos próximos a caducar (7 días)
        <span class="badge bg-warning text-dark ms-2">{{ $pendingAssignments->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($pendingAssignments->isEmpty())
            <p class="text-muted p-4 mb-0"><i class="fas fa-check-circle me-2 text-success"></i>No hay cursos próximos a caducar.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Curso</th>
                            <th>Fecha fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingAssignments as $a)
                            <tr>
                                <td><i class="fas fa-user me-2 text-muted"></i>{{ $a->user->name }}</td>
                                <td>{{ $a->courseCall->course->title }}<br>@php $type = $a->courseCall->course->type; @endphp<span style="padding:2px 8px; border-radius:20px; font-size:0.75rem; font-weight:600; background:{{ $type=='presencial' ? '#d1fae5' : ($type=='virtual' ? '#dbeafe' : '#f0fdf4') }}; color:{{ $type=='presencial' ? '#065f46' : ($type=='virtual' ? '#1e40af' : '#166534') }};">{{ ucfirst($type) }}</span></td>
                                <td><span class="text-danger fw-bold"><i class="fas fa-clock me-1"></i>{{ \Carbon\Carbon::parse($a->courseCall->end_date)->format('d/m/Y') }}</span></td>
                                <td>
                                    @if($a->status == 'pending')
                                        <span class="badge-pending">Pendiente</span>
                                    @else
                                        <span class="badge-progress">En curso</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- HISTÓRICO COMPLETADOS -->
<div class="card">
    <div class="card-header-custom">
        <i class="fas fa-history me-2"></i>Histórico de cursos completados
        <span class="badge bg-success ms-2">{{ $completedAssignments->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($completedAssignments->isEmpty())
            <p class="text-muted p-4 mb-0">No hay cursos completados.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Curso</th>
                            <th>Fecha fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedAssignments as $a)
                            <tr>
                                <td><i class="fas fa-user me-2 text-muted"></i>{{ $a->user->name }}</td>
                                <td>{{ $a->courseCall->course->title }}<br>@php $type = $a->courseCall->course->type; @endphp<span style="padding:2px 8px; border-radius:20px; font-size:0.75rem; font-weight:600; background:{{ $type=='presencial' ? '#d1fae5' : ($type=='virtual' ? '#dbeafe' : '#f0fdf4') }}; color:{{ $type=='presencial' ? '#065f46' : ($type=='virtual' ? '#1e40af' : '#166534') }};">{{ ucfirst($type) }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($a->courseCall->end_date)->format('d/m/Y') }}</td>
                                <td><span class="badge-completed"><i class="fas fa-check me-1"></i>Completado</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
<!-- CURSOS CADUCADOS -->
<div class="card mb-4">
    <div class="card-header-custom" style="background: linear-gradient(135deg, #7f1d1d, #dc2626);">
        <i class="fas fa-times-circle me-2"></i>Cursos caducados sin completar
        <span class="badge bg-danger ms-2">{{ $expiredAssignments->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($expiredAssignments->isEmpty())
            <p class="text-muted p-4 mb-0"><i class="fas fa-check-circle me-2 text-success"></i>No hay cursos caducados.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Curso</th>
                            <th>Fecha fin</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expiredAssignments as $a)
                            <tr>
                                <td><i class="fas fa-user me-2 text-muted"></i>{{ $a->user->name }}</td>
                                <td>{{ $a->courseCall->course->title }}<br>@php $type = $a->courseCall->course->type; @endphp<span style="padding:2px 8px; border-radius:20px; font-size:0.75rem; font-weight:600; background:{{ $type=='presencial' ? '#d1fae5' : ($type=='virtual' ? '#dbeafe' : '#f0fdf4') }}; color:{{ $type=='presencial' ? '#065f46' : ($type=='virtual' ? '#1e40af' : '#166534') }};">{{ ucfirst($type) }}</span></td>
                                <td><span class="text-danger fw-bold"><i class="fas fa-exclamation-circle me-1"></i>{{ \Carbon\Carbon::parse($a->courseCall->end_date)->format('d/m/Y') }}</span></td>
                                <td>
                                    @if($a->status == 'pending')
                                        <span class="badge-pending">Pendiente</span>
                                    @else
                                        <span class="badge-progress">En curso</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>



@endsection