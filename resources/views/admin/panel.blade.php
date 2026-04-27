@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Panel de Administración</h1>

    <!-- BOTÓN ENVÍO MANUAL -->
    <form action="{{ route('admin.sendCourseNotifications') }}" method="POST" class="mb-6">
        @csrf
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            🔔 Enviar notificaciones de vencimiento
        </button>
    </form>

    <!-- FILTROS -->
    <form method="GET" class="bg-white p-4 shadow rounded mb-6 flex gap-4 items-end flex-wrap">
        <div>
            <label class="block text-sm mb-1">Buscar empleado</label>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nombre del empleado"
                class="border p-2 rounded w-56">
        </div>

        <div>
            <label class="block text-sm mb-1">Empleado</label>
            <select name="user_id" class="border p-2 rounded w-56">
                <option value="">Todos</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}"
                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded h-[42px]">
            Filtrar
        </button>

        <a href="{{ route('admin.panel') }}" class="text-sm underline">
            Limpiar
        </a>
    </form>

    <!-- CURSOS PRÓXIMOS A CADUCAR -->
    <div class="bg-white p-4 shadow rounded mb-10">
        <h2 class="text-lg font-semibold mb-4">
            Cursos próximos a caducar (7 días)
        </h2>

        @if($pendingAssignments->isEmpty())
            <p class="text-gray-600">No hay cursos próximos a caducar.</p>
        @else
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Empleado</th>
                        <th class="border p-2">Curso</th>
                        <th class="border p-2">Fecha fin</th>
                        <th class="border p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingAssignments as $a)
                        <tr>
                            <td class="border p-2">{{ $a->user->name }}</td>
                            <td class="border p-2">{{ $a->courseCall->course->title }}</td>
                            <td class="border p-2 text-red-600 font-bold">
                                {{ $a->courseCall->end_date }}
                            </td>
                            <td class="border p-2">{{ $a->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- HISTÓRICO DE CURSOS COMPLETADOS -->
    <div class="bg-white p-4 shadow rounded">
        <h2 class="text-lg font-semibold mb-4">
            Histórico de cursos completados
        </h2>

        @if($completedAssignments->isEmpty())
            <p class="text-gray-600">No hay cursos completados.</p>
        @else
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Empleado</th>
                        <th class="border p-2">Curso</th>
                        <th class="border p-2">Fecha fin</th>
                        <th class="border p-2">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAssignments as $a)
                        <tr>
                            <td class="border p-2">{{ $a->user->name }}</td>
                            <td class="border p-2">{{ $a->courseCall->course->title }}</td>
                            <td class="border p-2">{{ $a->courseCall->end_date }}</td>
                            <td class="border p-2 text-green-600 font-bold">
                                Completado
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection


