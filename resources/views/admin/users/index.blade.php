@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-users me-2"></i>Usuarios</h1>
    <a href="{{ route('users.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i>Crear Usuario
    </a>
</div>

<!-- FILTROS Y EXPORTACIÓN -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end justify-content-between">
            <form method="GET" class="col-12 col-md-9">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Buscar usuario</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Nombre o email" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Concesionario</label>
                        <select name="codigo_concesionario_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($concesionarios as $concesionario)
                                <option value="{{ $concesionario->id }}"
                                    {{ request('codigo_concesionario_id') == $concesionario->id ? 'selected' : '' }}>
                                    {{ $concesionario->codigo }} – {{ $concesionario->ubicacion->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Puesto</label>
                        <select name="puesto_id" class="form-select">
                            <option value="">Todos</option>
                            @foreach($puestos as $puesto)
                                <option value="{{ $puesto->id }}"
                                    {{ request('puesto_id') == $puesto->id ? 'selected' : '' }}>
                                    {{ $puesto->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>Filtrar
                        </button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                            <i class="fas fa-times me-1"></i>Limpiar
                        </a>
                    </div>
                </div>
            </form>
            <div class="col-auto d-flex gap-2">
                <a href="{{ route('users.export.csv', request()->query()) }}" class="btn btn-success">
                    <i class="fas fa-file-csv me-1"></i>Exportar CSV
                </a>
                <a href="{{ route('users.export.excel', request()->query()) }}" class="btn btn-primary">
                    <i class="fas fa-file-excel me-1"></i>Exportar Excel
                </a>
            </div>
        </div>
    </div>
</div>

<!-- CONTADOR -->
@if ($users->total() > 0)
    <p class="text-muted mb-3">
        Mostrando <strong>{{ $users->firstItem() }}</strong> – <strong>{{ $users->lastItem() }}</strong>
        de <strong>{{ $users->total() }}</strong> usuarios
    </p>
@else
    <p class="text-muted mb-3">No hay usuarios para los filtros seleccionados</p>
@endif

<!-- TABLA -->
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0 table-compact">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Concesión</th>
                    <th>Ubicación</th>
                    <th>Departamento</th>
                    <th>Puesto</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td style="white-space: nowrap;">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge bg-primary">Admin</span>
                        @else
                            <span class="badge bg-secondary">Empleado</span>
                        @endif
                    </td>
                    <td>{{ $user->perfilEmpleado?->codigoConcesionario?->codigo ?? '-' }}</td>
                    <td>{{ $user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre ?? '-' }}</td>
                    <td>{{ $user->perfilEmpleado?->departamento?->nombre ?? '-' }}</td>
                    <td>{{ $user->perfilEmpleado?->puesto?->nombre ?? '-' }}</td>
                    <td>
                        @if($user->active)
                            <span class="badge-activo">Activo</span>
                        @else
                            <span class="badge-inactivo">Inactivo</span>
                        @endif
                    </td>
                    <td style="white-space: nowrap;">
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1">
                            <i class="fas fa-edit me-1"></i>Editar
                        </a>
                        <form action="{{ route('users.toggleActive', $user->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm {{ $user->active ? 'btn-secondary' : 'btn-success' }} me-1">
                                {{ $user->active ? 'Desactivar' : 'Activar' }}
                            </button>
                        </form>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">
                                <i class="fas fa-trash me-1"></i>Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection