@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-2xl font-bold mb-6">Mis cursos</h1>

    <div class="bg-white p-4 shadow rounded">
        <h2 class="font-semibold mb-3">Cursos pendientes</h2>

        @if($pendingAssignments->isEmpty())
            <p class="text-gray-600">No tienes cursos pendientes.</p>
        @else
            <ul class="list-disc ml-6">
                @foreach($pendingAssignments as $a)
                    <li>{{ $a->courseCall->course->title }}</li>
                @endforeach
            </ul>
        @endif
    </div>

</div>
@endsection
