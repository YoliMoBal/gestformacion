@extends('layouts.app')

@section('content')
<h1 class="text-2xl mb-4">Editar usuario</h1>

<form action="{{ route('users.update', $user->id) }}" method="POST" class="bg-white p-4 rounded shadow">
    @csrf
    @method('PUT')

    {{-- DATOS PERSONALES --}}
    <h2 class="font-semibold mb-2">Datos personales</h2>

    <label class="block mb-2">Nombre</label>
    <input type="text" name="name" value="{{ $user->name }}" class="border p-2 w-full mb-4">

    <label class="block mb-2">Email</label>
    <input type="email" name="email" value="{{ $user->email }}" class="border p-2 w-full mb-4">

    <label class="block mb-2">Rol</label>
    <select name="role" id="role" class="border p-2 w-full mb-4">
        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administrador</option>
        <option value="empleado" {{ $user->role == 'empleado' ? 'selected' : '' }}>Empleado</option>
    </select>

    {{-- DATOS LABORALES --}}
    <div id="datos-laborales">
        <h2 class="font-semibold mt-6 mb-2">Datos laborales</h2>

        <label class="block mb-2">Ubicación</label>
        <select id="ubicacion" class="border p-2 w-full mb-4">
            <option value="">Selecciona una ubicación</option>
            @foreach($ubicaciones as $ubicacion)
                <option value="{{ $ubicacion->id }}"
                    {{ optional($perfil?->codigoConcesionario?->ubicacion)->id == $ubicacion->id ? 'selected' : '' }}>
                    {{ $ubicacion->nombre }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2">Código concesionario</label>
        <select name="codigo_concesionario_id" id="codigo_concesionario" class="border p-2 w-full mb-4">
            <option value="">Selecciona un código</option>
            @foreach($ubicaciones as $ubicacion)
                @foreach($ubicacion->codigosConcesionario as $codigo)
                    <option value="{{ $codigo->id }}"
                        data-ubicacion="{{ $ubicacion->id }}"
                        {{ $perfil?->codigo_concesionario_id == $codigo->id ? 'selected' : '' }}>
                        {{ $codigo->codigo }} ({{ $ubicacion->nombre }})
                    </option>
                @endforeach
            @endforeach
        </select>

        <label class="block mb-2">Departamento</label>
        <select name="departamento_id" id="departamento" class="border p-2 w-full mb-4">
            <option value="">Selecciona un departamento</option>
            @foreach($departamentos as $departamento)
                <option value="{{ $departamento->id }}"
                    {{ $perfil?->departamento_id == $departamento->id ? 'selected' : '' }}>
                    {{ $departamento->nombre }}
                </option>
            @endforeach
        </select>

        <label class="block mb-2">Puesto</label>
        <select name="puesto_id" id="puesto" class="border p-2 w-full mb-4">
            <option value="">Selecciona un puesto</option>
            @foreach($departamentos as $departamento)
                @foreach($departamento->puestos as $puesto)
                    <option value="{{ $puesto->id }}"
                        data-departamento="{{ $departamento->id }}"
                        {{ $perfil?->puesto_id == $puesto->id ? 'selected' : '' }}>
                        {{ $puesto->nombre }}
                    </option>
                @endforeach
            @endforeach
        </select>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
        Guardar cambios
    </button>
</form>

<script>
document.getElementById('datos-laborales').style.display = 'block';



// Filtros
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
