
@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white shadow rounded">

    <h1 class="text-xl font-bold mb-4">Editar estado del curso</h1>

    <p><b>Empleado:</b> {{ $assignment->user->name }}</p>
    <p><b>Curso:</b> {{ $assignment->courseCall?->course?->title }}</p>



    <form action="{{ route('assignments.update', $assignment->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <select name="status" class="border p-2 rounded">
            <option value="pending" {{ $assignment->status=='pending'?'selected':'' }}>Pendiente</option>
            <option value="in_progress" {{ $assignment->status=='in_progress'?'selected':'' }}>En progreso</option>
            <option value="completed" {{ $assignment->status=='completed'?'selected':'' }}>Completado</option>
        </select>

        <button class="bg-blue-600 text-white px-4 py-2 rounded ml-2">
            Guardar
        </button>
    </form>

</div>
@endsection
