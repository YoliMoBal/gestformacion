
@extends('layouts.app')


@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Panel de Administración</h1>

    <!--  BOTÓN ENVÍO MANUAL (UNO SOLO) -->
    <form action="{{ route('admin.sendCourseNotifications') }}" method="POST" class="mb-8">
        @csrf
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
            🔔 Enviar notificaciones de vencimiento
        </button>
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


