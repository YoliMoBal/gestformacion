@extends('layouts.app')

@section('content')

<h1>Asignar convocatoria a empleado</h1>

<a href="{{ route('assignments.index') }}" class="btn btn-secondary mb-3">
    ← Volver
</a>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('assignments.store') }}" method="POST">
    @csrf

    {{-- Empleado --}}
    <div class="mb-3">
        <label class="form-label">Empleado</label>
        <select name="user_id" class="form-select" required>
            <option value="">-- Selecciona empleado --</option>
            @foreach($users as $user)
                <option value="{{ $user->id }}">
                    {{ $user->name }} ({{ $user->email }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Convocatoria --}}
    <div class="mb-3">
        <label class="form-label">Convocatoria</label>
        <select name="course_call_id" class="form-select" required>
            <option value="">-- Selecciona convocatoria --</option>
            @foreach($calls as $call)
                <option value="{{ $call->id }}">
                    {{ $call->course->title }}
                    ({{ $call->start_date }} - {{ $call->end_date }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Estado --}}
    <div class="mb-3">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select" required>
            <option value="pending">Pendiente</option>
            <option value="in_progress">En progreso</option>
            <option value="completed">Completado</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">
        Asignar convocatoria
    </button>
</form>

@endsection


