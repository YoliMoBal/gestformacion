@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-user-plus me-2"></i>Crear Usuario</h1>

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
        <form action="{{ route('users.store') }}" method="POST" autocomplete="off">
            @csrf

            <h5 class="fw-bold mb-3">Datos personales</h5>

            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" autocomplete="off" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" autocomplete="off" required>
            </div>

            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" autocomplete="off" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Rol</label>
                <select name="role" class="form-select">
                    <option value="employee">Empleado</option>
                    <option value="admin">Administrador</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" autocomplete="new-password" required>
            </div>

            <h5 class="fw-bold mt-4 mb-3">Datos laborales</h5>

            <div class="mb-3">
                <label class="form-label">Ubicación</label>
                <select id="ubicacion" class="form-select">
                    <option value="">Selecciona una ubicación</option>
                    @foreach($ubicaciones as $ubicacion)
                        <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Código concesionario</label>
                <select name="codigo_concesionario_id" id="codigo_concesionario" class="form-select">
                    <option value="">Selecciona un código</option>
                    @foreach($ubicaciones as $ubicacion)
                        @foreach($ubicacion->codigosConcesionario as $codigo)
                            <option value="{{ $codigo->id }}" data-ubicacion="{{ $ubicacion->id }}">
                                {{ $codigo->codigo }} ({{ $ubicacion->nombre }})
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Departamento</label>
                <select name="departamento_id" id="departamento" class="form-select">
                    <option value="">Selecciona un departamento</option>
                    @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Puesto</label>
                <select name="puesto_id" id="puesto" class="form-select">
                    <option value="">Selecciona un puesto</option>
                    @foreach($puestos as $puesto)
                        <option value="{{ $puesto->id }}" data-departamento="{{ $puesto->departamento_id }}">
                            {{ $puesto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Crear usuario
                </button>
                <a href="{{ route('users.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function filtrarPuestos() {
    const departamentoId = document.getElementById('departamento').value;
    document.querySelectorAll('#puesto option').forEach(option => {
        if (!option.dataset.departamento) {
            option.style.display = 'block';
        } else {
            option.style.display = option.dataset.departamento === departamentoId ? 'block' : 'none';
        }
    });
}

document.getElementById('ubicacion').addEventListener('change', function () {
    const ubicacionId = this.value;
    document.querySelectorAll('#codigo_concesionario option').forEach(option => {
        option.style.display = !option.dataset.ubicacion || option.dataset.ubicacion === ubicacionId
            ? 'block' : 'none';
    });
});

document.getElementById('departamento').addEventListener('change', filtrarPuestos);
filtrarPuestos();
</script>

@endsection