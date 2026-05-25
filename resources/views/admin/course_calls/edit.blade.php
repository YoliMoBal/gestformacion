@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-calendar me-2"></i>Editar convocatoria</h1>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@php $tipo = $courseCall->course->type; @endphp

<div class="card">
    <div class="card-body">
        <form action="{{ route('course-calls.update', $courseCall) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Curso</label>
                <select name="course_id" class="form-select" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}"
                            {{ $courseCall->course_id === $course->id ? 'selected' : '' }}>
                            {{ $course->title }} ({{ ucfirst($course->type) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- CAMPOS E-LEARNING -->
            @if($tipo === 'e-learning')
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="start_date" class="form-control"
                        value="{{ $courseCall->start_date }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Fecha límite (plazo)</label>
                    <input type="date" name="end_date" class="form-control"
                        value="{{ $courseCall->end_date }}" required>
                </div>
            </div>
            @endif

            <!-- CAMPOS PRESENCIAL -->
            @if($tipo === 'presencial')
            <div class="row g-3 mt-1">
                <div class="col-md-4">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="fecha_curso" class="form-control"
                        value="{{ $courseCall->fecha_curso }}" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Duración (días hábiles)</label>
                    <input type="number" name="duracion_dias" class="form-control"
                        value="{{ $courseCall->duracion_dias }}" min="1" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Fecha fin (calculada)</label>
                    <input type="date" name="end_date_presencial" class="form-control"
                        value="{{ $courseCall->end_date }}" readonly style="background:#f8f9fa;">
                </div>
            </div>

            <div class="row g-3 mt-1">
                <div class="col-12">
                    <label class="form-label fw-bold">Horario de mañana</label>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora inicio mañana</label>
                    <input type="time" name="hora_inicio_manana" class="form-control"
                        value="{{ $courseCall->hora }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora fin mañana</label>
                    <input type="time" name="hora_fin_manana" class="form-control"
                        value="{{ $courseCall->hora_fin }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora inicio tarde (opcional)</label>
                    <input type="time" name="hora_inicio_tarde" class="form-control"
                        value="{{ $courseCall->hora_inicio_tarde }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora fin tarde (opcional)</label>
                    <input type="time" name="hora_fin_tarde" class="form-control"
                        value="{{ $courseCall->hora_fin_tarde }}">
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Ubicación del curso</label>
                <input type="text" name="ubicacion_curso" class="form-control"
                    value="{{ $courseCall->ubicacion_curso }}"
                    placeholder="Ej: Sede Marbella, Sala de formación...">
            </div>
            @endif

            <!-- CAMPOS VIRTUAL -->
            @if($tipo === 'virtual')
            <div class="row g-3 mt-1">
                <div class="col-md-3">
                    <label class="form-label">Fecha del curso</label>
                    <input type="date" name="fecha_curso_virtual" class="form-control"
                        value="{{ $courseCall->fecha_curso }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora de inicio</label>
                    <input type="time" name="hora" class="form-control"
                        value="{{ $courseCall->hora }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Hora de fin</label>
                    <input type="time" name="hora_fin" class="form-control"
                        value="{{ $courseCall->hora_fin }}" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Duración (horas)</label>
                    <input type="number" name="duracion_horas" class="form-control"
                        value="{{ $courseCall->duracion_horas }}" min="0.5" step="0.5" required>
                </div>
            </div>
            @endif

            <!-- OPCIONES DE AVISO -->
            <div class="mb-3 mt-4">
                <label class="form-label fw-bold">Notificaciones</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_auto" value="auto"
                        {{ $courseCall->notify_days_before == 7 ? 'checked' : '' }}
                        onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_auto">
                        Automático (avisar 7, 3 y 1 día antes)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_custom" value="custom"
                        {{ $courseCall->notify_days_before > 0 && $courseCall->notify_days_before != 7 ? 'checked' : '' }}
                        onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_custom">
                        Personalizado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_no" value="no"
                        {{ $courseCall->notify_days_before == 0 ? 'checked' : '' }}
                        onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_no">
                        No avisar
                    </label>
                </div>
                <div id="aviso_personalizado"
                    style="display:{{ $courseCall->notify_days_before > 0 && $courseCall->notify_days_before != 7 ? 'block' : 'none' }};"
                    class="mt-2">
                    <label class="form-label">Avisar (días antes)</label>
                    <input type="number" name="notify_days_before" class="form-control w-25"
                        min="1" max="30" value="{{ $courseCall->notify_days_before }}">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Guardar cambios
                </button>
                <a href="{{ route('course-calls.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleAviso() {
    const val = document.querySelector('input[name="tipo_aviso"]:checked').value;
    document.getElementById('aviso_personalizado').style.display = val === 'custom' ? 'block' : 'none';
}
</script>

@endsection