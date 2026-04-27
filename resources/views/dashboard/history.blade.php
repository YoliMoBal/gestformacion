@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Histórico de cursos</h1>

    <!-- FILTROS -->
    <form method="GET" class="bg-white p-4 shadow rounded mb-6 flex gap-4 items-end flex-wrap">
        <div>
            <label class="block text-sm mb-1">Buscar curso</label>
            <input type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nombre del curso"
                class="border p-2 rounded w-56">
        </div>

        <div>
            <label class="block text-sm mb-1">Tipo de curso</label>
            <select name="type" class="border p-2 rounded w-44">
                <option value="">Todos</option>
                <option value="presencial" {{ request('type') == 'presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="e-learning" {{ request('type') == 'e-learning' ? 'selected' : '' }}>E-learning</option>
                <option value="virtual" {{ request('type') == 'virtual' ? 'selected' : '' }}>Virtual</option>
            </select>
        </div>

        <button class="bg-blue-500 text-white px-4 py-2 rounded h-[42px]">
            Filtrar
        </button>

        <a href="{{ route('dashboard.history') }}" class="text-sm underline">
            Limpiar
        </a>
    </form>

    <!-- TABLA HISTÓRICO -->
    <div class="bg-white p-4 shadow rounded">
        <h2 class="font-semibold mb-3">Cursos completados</h2>

        @if($completedAssignments->isEmpty())
            <p class="text-gray-600">Aún no has completado cursos.</p>
        @else
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">Curso</th>
                        <th class="border p-2 text-left">Tipo</th>
                        <th class="border p-2 text-left">Fecha inicio</th>
                        <th class="border p-2 text-left">Fecha fin</th>
                        <th class="border p-2 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAssignments as $a)
                        <tr>
                            <td class="border p-2">{{ $a->courseCall->course->title }}</td>
                            <td class="border p-2">{{ $a->courseCall->course->type }}</td>
                            <td class="border p-2">{{ $a->courseCall->start_date }}</td>
                            <td class="border p-2">{{ $a->courseCall->end_date }}</td>
                            <td class="border p-2 text-green-600 font-bold">Completado</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</div>
@endsection
