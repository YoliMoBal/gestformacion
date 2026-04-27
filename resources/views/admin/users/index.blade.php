@extends('layouts.app')


@section('content')
<h1 class="text-2xl mb-4">Usuarios</h1>
<a href="{{ route('users.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-2 inline-block">Crear Usuario</a>

<div class="mb-4 flex items-end justify-between gap-4">

    <!-- BLOQUE FILTROS -->
    <form method="GET" class="flex gap-4 items-end flex-wrap">
        <!-- Buscar -->
        <div>
            <label class="block text-sm mb-1">Buscar usuario</label>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nombre o email"
                class="border p-2 rounded w-64">
        </div>

        <!-- Concesionario -->
        <div style="min-width: 320px">
            <label class="block text-sm mb-1">Concesionario</label>
            <select name="codigo_concesionario_id"
                class="border p-2 rounded w-full">
                <option value="">Todos</option>
                @foreach($concesionarios as $concesionario)
                <option value="{{ $concesionario->id }}"
                    {{ request('codigo_concesionario_id') == $concesionario->id ? 'selected' : '' }}>
                    {{ $concesionario->codigo }} – {{ $concesionario->ubicacion->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Puesto -->
        <div>
            <label class="block text-sm mb-1">Puesto</label>
            <select name="puesto_id"
                class="border p-2 rounded w-64">
                <option value="">Todos</option>
                @foreach($puestos as $puesto)
                <option value="{{ $puesto->id }}"
                    {{ request('puesto_id') == $puesto->id ? 'selected' : '' }}>
                    {{ $puesto->nombre }}
                </option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded h-[42px]">
            Filtrar
        </button>

        <a href="{{ route('users.index') }}" class="text-sm underline mb-2">
            Limpiar
        </a>
    </form>

    <!-- BLOQUE EXPORTACIÓN -->
    <div class="flex gap-2">
        <a href="{{ route('users.export.csv', request()->query()) }}"
            style="
               background-color:#16a34a;
               color:white;
               display:inline-flex;
               align-items:center;
               justify-content:center;
               padding:0.5rem 1rem;
               border-radius:0.375rem;
               height:42px;
           ">
            Exportar CSV
        </a>

        <a href="{{ route('users.export.excel', request()->query()) }}"
            style="
               background-color:#2563eb;
               color:white;
               display:inline-flex;
               align-items:center;
               justify-content:center;
               padding:0.5rem 1rem;
               border-radius:0.375rem;
               height:42px;
           ">
            Exportar Excel
        </a>
    </div>

</div>



@if ($users->total() > 0)
<div class="mb-2 text-sm text-gray-600">
    Mostrando
    <strong>{{ $users->firstItem() }}</strong>
    –
    <strong>{{ $users->lastItem() }}</strong>
    de
    <strong>{{ $users->total() }}</strong>
    usuarios
</div>
@else
<div class="mb-2 text-sm text-gray-600">
    No hay usuarios para los filtros seleccionados
</div>
@endif


<table class="min-w-full bg-white shadow rounded">
    <thead>
        <tr>
            <th class="p-2 border">ID</th>
            <th class="p-2 border">Nombre</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Rol</th>
            <th class="p-2 border">Código Concesión</th>
            <th class="p-2 border">Ubicación</th>
            <th class="p-2 border">Departamento</th>
            <th class="p-2 border">Puesto</th>
            <th class="p-2 border">Estado</th>
            <th class="p-2 border">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td class="p-2 border">{{ $user->id }}</td>
            <td class="p-2 border">{{ $user->name }}</td>
            <td class="p-2 border">{{ $user->email }}</td>
            <td class="p-2 border">{{ $user->role }}</td>
            <td class="p-2 border">
                {{ $user->perfilEmpleado?->codigoConcesionario?->codigo ?? '-' }}
            </td>

            <td class="p-2 border">
                {{ $user->perfilEmpleado?->codigoConcesionario?->ubicacion?->nombre ?? '-' }}
            </td>

            <td class="p-2 border">
                {{ $user->perfilEmpleado?->departamento?->nombre ?? '-' }}
            </td>

            <td class="p-2 border">
                {{ $user->perfilEmpleado?->puesto?->nombre ?? '-' }}
            </td>
            <td class="p-2 border">
                <span class="{{ $user->active ? 'text-green-600' : 'text-red-500' }} font-semibold">
                    {{ $user->active ? 'Activo' : 'Inactivo' }}
                </span>
            </td>
            <td class="p-2 border">

                <a href="{{ route('users.edit', $user->id) }}" class="bg-yellow-400 px-2 py-1 rounded">Editar</a>

                <form action="{{ route('users.toggleActive', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('PATCH')
                    <button class="{{ $user->active ? 'bg-gray-400' : 'bg-green-500' }} px-2 py-1 rounded text-white">
                        {{ $user->active ? 'Desactivar' : 'Activar' }}
                    </button>
                </form>

                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button class="bg-red-500 px-2 py-1 rounded text-white"
                        onclick="return confirm('¿Eliminar usuario?')">
                        Eliminar
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>

<div class="mt-4">
    {{ $users->links() }}
</div>

@endsection