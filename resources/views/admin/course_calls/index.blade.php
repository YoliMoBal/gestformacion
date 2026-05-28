@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-calendar me-2"></i>Convocatorias</h1>
    <a href="{{ route('course-calls.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Crear convocatoria
    </a>
</div>

<!-- BUSCADOR -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label">Buscar curso</label>
                <input type="text" id="buscador" class="form-control" placeholder="Nombre del curso...">
            </div>
            <div class="col-md-3">
                <label class="form-label">Tipo</label>
                <select id="filtro_tipo" class="form-select">
                    <option value="">Todos los tipos</option>
                    <option value="presencial">Presencial</option>
                    <option value="e-learning">E-learning</option>
                    <option value="virtual">Virtual</option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover mb-0" id="tabla_convocatorias">
            <thead>
                <tr>
                    <th>Curso</th>
                    <th>Tipo</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Avisar (días)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($calls as $call)
                    <tr data-nombre="{{ strtolower($call->course->title) }}" data-tipo="{{ $call->course->type }}">
                        <td>{{ $call->course->title }}</td>
                        <td>
                            @if($call->course->type == 'presencial')
                                <span class="badge bg-success">Presencial</span>
                            @elseif($call->course->type == 'e-learning')
                                <span class="badge bg-info text-dark">E-learning</span>
                            @else
                                <span class="badge bg-primary">Virtual</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($call->start_date)->format('d/m/Y') }}</td>
                        <td>
                            @if($call->end_date < now()->format('Y-m-d'))
                                <span class="text-danger fw-bold"><i class="fas fa-exclamation-circle me-1"></i>{{ \Carbon\Carbon::parse($call->end_date)->format('d/m/Y') }}</span>
                            @else
                                {{ \Carbon\Carbon::parse($call->end_date)->format('d/m/Y') }}
                            @endif
                        </td>
                        <td><span class="badge bg-secondary">7 · 3 · 1 días</span></td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('course-calls.edit', $call) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <form action="{{ route('course-calls.destroy', $call) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('¿Eliminar esta convocatoria?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-calendar me-2"></i>No hay convocatorias creadas
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function normalizar(t) {
    return t.toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, "");
}
document.getElementById('buscador').addEventListener('input', filtrar);
document.getElementById('filtro_tipo').addEventListener('change', filtrar);

function filtrar() {
    const texto = normalizar(document.getElementById('buscador').value);
    const tipo = document.getElementById('filtro_tipo').value;
    document.querySelectorAll('#tabla_convocatorias tbody tr').forEach(row => {
        const nombre = normalizar(row.dataset.nombre || "");
        const tipoCurso = row.dataset.tipo || "";
        const matchTexto = !texto || nombre.includes(texto);
        const matchTipo = !tipo || tipoCurso === tipo;
        row.style.display = matchTexto && matchTipo ? "" : "none";
    });
}
</script>
@endsection
