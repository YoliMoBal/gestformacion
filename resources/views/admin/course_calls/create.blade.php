@extends('layouts.app')

@section('content')

<h1 class="page-title"><i class="fas fa-calendar me-2"></i>Crear convocatoria</h1>

@if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('course-calls.store') }}" method="POST">
            @csrf

            <!-- FILTRO TIPO + BUSCADOR + SELECTOR CURSO -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label class="form-label">Filtrar por tipo</label>
                    <select id="filtro_tipo" class="form-select">
                        <option value="">Todos los tipos</option>
                        <option value="presencial">Presencial</option>
                        <option value="e-learning">E-learning</option>
                        <option value="virtual">Virtual</option>
                    </select>
                </div>
                <div class="col-md-8">
                    <label class="form-label">Buscar curso</label>
                    <input type="text" id="buscar_curso" class="form-control" placeholder="Escribe para buscar...">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Curso</label>
                <select name="course_id" id="course_id" class="form-select" size="5" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" data-tipo="{{ $course->type }}"
                            data-texto="{{ strtolower($course->title) }}">
                            {{ $course->title }} ({{ ucfirst($course->type) }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- CAMPOS E-LEARNING -->
            <div id="campos_elearning" style="display:none;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Fecha inicio</label>
                        <input type="date" name="start_date" id="start_date" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Fecha límite (plazo)</label>
                        <input type="date" name="end_date" id="end_date" class="form-control">
                    </div>
                </div>
            </div>

            <!-- CAMPOS PRESENCIAL -->
            <div id="campos_presencial" style="display:none;">
                <div class="row g-3 mt-1">
                    <div class="col-md-4">
                        <label class="form-label">Fecha inicio</label>
                        <input type="date" name="fecha_curso" id="fecha_curso" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Duración (días hábiles)</label>
                        <input type="number" name="duracion_dias" id="duracion_dias"
                            class="form-control" min="1" value="1">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Fecha fin (calculada)</label>
                        <input type="date" name="end_date_presencial" id="end_date_presencial"
                            class="form-control" readonly style="background:#f8f9fa;">
                    </div>
                </div>

                <div class="row g-3 mt-1">
                    <div class="col-12">
                        <label class="form-label fw-bold">Horario de mañana</label>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora inicio mañana</label>
                        <input type="time" name="hora_inicio_manana" class="form-control" value="09:00">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora fin mañana</label>
                        <input type="time" name="hora_fin_manana" class="form-control" value="14:00">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora inicio tarde (opcional)</label>
                        <input type="time" name="hora_inicio_tarde" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora fin tarde (opcional)</label>
                        <input type="time" name="hora_fin_tarde" class="form-control">
                    </div>
                </div>

                <div class="mt-3">
                    <label class="form-label">Ubicación del curso</label>
                    <input type="text" name="ubicacion_curso" class="form-control"
                        placeholder="Ej: Sede Marbella, Sala de formación...">
                </div>
            </div>

            <!-- CAMPOS VIRTUAL -->
            <div id="campos_virtual" style="display:none;">
                <div class="row g-3 mt-1">
                    <div class="col-md-3">
                        <label class="form-label">Fecha del curso</label>
                        <input type="date" name="fecha_curso_virtual" id="fecha_curso_virtual" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora de inicio</label>
                        <input type="time" name="hora" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Hora de fin</label>
                        <input type="time" name="hora_fin" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Duración (horas)</label>
                        <input type="number" name="duracion_horas" id="duracion_horas"
                            class="form-control" min="0.5" step="0.5" value="1">
                    </div>
                </div>
            </div>

            <!-- OPCIONES DE AVISO -->
            <div class="mb-3 mt-4">
                <label class="form-label fw-bold">Notificaciones</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_auto" value="auto" checked onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_auto">
                        Automático (avisar 7, 3 y 1 día antes)
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_custom" value="custom" onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_custom">
                        Personalizado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tipo_aviso"
                        id="aviso_no" value="no" onchange="toggleAviso()">
                    <label class="form-check-label" for="aviso_no">
                        No avisar
                    </label>
                </div>
                <div id="aviso_personalizado" style="display:none;" class="mt-2">
                    <label class="form-label">Avisar (días antes)</label>
                    <input type="number" name="notify_days_before" class="form-control w-25"
                        min="1" max="30" value="7">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Guardar convocatoria
                </button>
                <a href="{{ route('course-calls.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left me-2"></i>Volver
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function normalizar(texto) {
    return texto.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

function actualizarCampos() {
    const select = document.getElementById('course_id');
    const selectedOption = select.options[select.selectedIndex];
    const tipo = selectedOption?.dataset.tipo;

    document.getElementById('campos_elearning').style.display = tipo === 'e-learning' ? 'block' : 'none';
    document.getElementById('campos_presencial').style.display = tipo === 'presencial' ? 'block' : 'none';
    document.getElementById('campos_virtual').style.display = tipo === 'virtual' ? 'block' : 'none';
}

function calcularFechaFinPresencial() {
    const fecha = document.getElementById('fecha_curso').value;
    const duracion = parseInt(document.getElementById('duracion_dias').value || 1);
    if (fecha && duracion) {
        const fechaObj = new Date(fecha);
        let diasHabiles = 0;
        while (diasHabiles < duracion - 1) {
            fechaObj.setDate(fechaObj.getDate() + 1);
            const dia = fechaObj.getDay();
            if (dia !== 0 && dia !== 6) diasHabiles++;
        }
        document.getElementById('end_date_presencial').value = fechaObj.toISOString().split('T')[0];
    }
}

document.getElementById('fecha_curso').addEventListener('change', calcularFechaFinPresencial);
document.getElementById('duracion_dias').addEventListener('change', calcularFechaFinPresencial);
document.getElementById('filtro_tipo').addEventListener('change', filtrarCursos);
document.getElementById('buscar_curso').addEventListener('input', filtrarCursos);

function filtrarCursos() {
    const tipo = document.getElementById('filtro_tipo').value;
    const texto = normalizar(document.getElementById('buscar_curso').value);
    document.querySelectorAll('#course_id option').forEach(option => {
        const tipoMatch = !tipo || option.dataset.tipo === tipo;
        const textoMatch = !texto || normalizar(option.dataset.texto || '').includes(texto);
        option.style.display = tipoMatch && textoMatch ? 'block' : 'none';
    });
}

function toggleAviso() {
    const val = document.querySelector('input[name="tipo_aviso"]:checked').value;
    document.getElementById('aviso_personalizado').style.display = val === 'custom' ? 'block' : 'none';
}

document.getElementById('course_id').addEventListener('change', actualizarCampos);
actualizarCampos();
</script>

@endsection