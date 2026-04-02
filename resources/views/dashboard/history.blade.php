@extends('layouts.app')


@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Histórico de cursos</h1>

    <div class="bg-white p-4 shadow rounded">
        <h2 class="font-semibold mb-3">Cursos completados</h2>

        @if($completedAssignments->isEmpty())
            <p class="text-gray-600">Aún no has completado cursos.</p>
        @else
            <ul class="list-disc ml-6">
                @foreach($completedAssignments as $a)
                    <li>{{ $a->courseCall->course->title }}</li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
@endsection
