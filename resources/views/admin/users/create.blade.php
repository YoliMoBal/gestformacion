@extends('layouts.app')

@section('content')
<h1 class="text-2xl mb-4">Crear Usuario</h1>
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 p-3 mb-4 rounded">
        <ul>
            @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('users.store') }}" method="POST" class="bg-white p-4 rounded shadow">
    @csrf

    {{-- DATOS PERSONALES --}}
    <h2 class="font-semibold mb-2">Datos personales</h2>

    <label class="block mb-2">Nombre</label>
    <input type="text" name="name" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Email</label>
    <input type="email" name="email" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">DNI</label>
    <input type="text" name="dni" class="border p-2 w-full mb-4" required>

    <label class="block mb-2">Rol</label>
    <select name="role" class="border p-2 w-full mb-4">
        <option value="empleado">Empleado</option>
        <option value="admin">Administrador</option>
    </select>

    <label class="block mb-2">Contraseña</label>
    <input type="password" name="password" class="border p-2 w-full mb-4" required>

    {{-- DATOS LABORALES --}}
    <h2 class="font-semibold mt-6 mb-2">Datos laborales</h2>

    <label class="block mb-2">Ubicación</label>
    <select id="ubicacion" class="border p-2 w-full mb-4">
        <option value="">Selecciona una ubicación</option>
        @foreach($ubicaciones as $ubicacion)
            <option value="{{ $ubicacion->id }}">{{ $ubicacion->nombre }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Código concesionario</label>
    <select name="codigo_concesionario_id" id="codigo_concesionario" class="border p-2 w-full mb-4" required>
        <option value="">Selecciona un código</option>
        @foreach($ubicaciones as $ubicacion)
            @foreach($ubicacion->codigosConcesionario as $codigo)
                <option value="{{ $codigo->id }}" data-ubicacion="{{ $ubicacion->id }}">
                    {{ $codigo->codigo }} ({{ $ubicacion->nombre }})
                </option>
            @endforeach
        @endforeach
    </select>

    <label class="block mb-2">Departamento</label>
    <select name="departamento_id" id="departamento" class="border p-2 w-full mb-4" required>
        <option value="">Selecciona un departamento</option>
        @foreach($departamentos as $departamento)
            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
        @endforeach
    </select>

    <label class="block mb-2">Puesto</label>
    <select name="puesto_id" id="puesto" class="border p-2 w-full mb-4" required>
        <option value="">Selecciona un puesto</option>
        @foreach($departamentos as $departamento)
            @foreach($departamento->puestos as $puesto)
                <option value="{{ $puesto->id }}" data-departamento="{{ $departamento->id }}">
                    {{ $puesto->nombre }}
                </option>
            @endforeach
        @endforeach
    </select>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        Crear usuario
    </button>
</form>

{{-- JS SIMPLE PARA FILTRAR SELECTS --}}
<script>
document.getElementById('ubicacion').addEventListener('change', function () {
    const ubicacionId = this.value;
    document.querySelectorAll('#codigo_concesionario option').forEach(option => {
        option.style.display = !option.dataset.ubicacion || option.dataset.ubicacion === ubicacionId
            ? 'block'
            : 'none';
    });
});

document.getElementById('departamento').addEventListener('change', function () {
    const departamentoId = this.value;
    document.querySelectorAll('#puesto option').forEach(option => {
        option.style.display = !option.dataset.departamento || option.dataset.departamento === departamentoId
            ? 'block'
            : 'none';
    });
});
</script>
@endsection
