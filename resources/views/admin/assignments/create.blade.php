@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-tasks me-2"></i>Asignar convocatoria a empleado</h1>

@if ($errors->any())
<div class="alert alert-danger mb-4">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('assignments.store') }}" method="POST">
            @csrf

            <!-- EMPLEADO CON BUSCADOR -->
            <div class="mb-4">
                <label class="form-label fw-bold">Empleado</label>
                <input type="text" id="buscarEmpleado" class="form-control mb-2"
                    placeholder="Escribe para buscar por nombre, ubicación, departamento o puesto...">
                <select name="user_id" id="selectEmpleado" class="form-select" size="6" required>
                    @foreach($users as $user)
                    @if($user->role === 'employee')
                    <option value="{{ $user->id }}"
                        data-texto="{{ strtolower($user->name) }} {{ strtolower($user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre ?? '') }} {{ strtolower($user->perfilEmpleado?->departamento?->nombre ?? '') }} {{ strtolower($user->perfilEmpleado?->puesto?->nombre ?? '') }}">
                        {{ $user->name }}
                        @if($user->perfilEmpleado)
                        — {{ $user->perfilEmpleado->codigoConcesionario?->codigo ?? '' }}
                        {{ $user->perfilEmpleado->codigoConcesionario?->ubicacion?->nombre ?? '' }}
                        | {{ $user->perfilEmpleado->departamento?->nombre ?? '' }}
                        | {{ $user->perfilEmpleado->puesto?->nombre ?? '' }}
                        @endif
                    </option>
                    @endif
                    @endforeach
                </select>
                <small class="text-muted">Selecciona un empleado de la lista</small>
            </div>

            <!-- CONVOCATORIA CON BUSCADOR -->
            <div class="mb-4">
                <label class="form-label fw-bold">Convocatoria</label>
                <input type="text" id="buscarConvocatoria" class="form-control mb-2"
                    placeholder="Escribe para buscar por nombre de curso...">
                <select name="course_call_id" id="selectConvocatoria" class="form-select" size="6" required>
                    @foreach($calls as $call)
                    <option value="{{ $call->id }}"
                        data-texto="{{ strtolower($call->course->title) }}">
                        {{ $call->course->title }}
                        ({{ $call->start_date }} — {{ $call->end_date }})
                    </option>
                    @endforeach
                </select>
                <small class="text-muted">Selecciona una convocatoria de la lista</small>
            </div>

            <!-- ESTADO OCULTO SIEMPRE PENDIENTE -->
            <input type="hidden" name="status" value="pending">

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Asignar convocatoria
                </button>
                <a href="{{ route('assignments.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function normalizar(texto) {
    return texto.toLowerCase()
        .normalize("NFD")
        .replace(/[\u0300-\u036f]/g, "");
}

// Buscador empleados
document.getElementById('buscarEmpleado').addEventListener('input', function() {
    const texto = normalizar(this.value);
    document.querySelectorAll('#selectEmpleado option').forEach(option => {
        option.style.display = normalizar(option.dataset.texto).includes(texto) ? 'block' : 'none';
    });
});

// Buscador convocatorias
document.getElementById('buscarConvocatoria').addEventListener('input', function() {
    const texto = normalizar(this.value);
    document.querySelectorAll('#selectConvocatoria option').forEach(option => {
        option.style.display = normalizar(option.dataset.texto).includes(texto) ? 'block' : 'none';
    });
});
</script>

@endsection