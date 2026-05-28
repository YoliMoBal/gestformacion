@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="page-title mb-0"><i class="fas fa-book me-2"></i>Cursos</h1>
    <a href="{{ route('courses.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Crear curso
    </a>
</div>

<!-- BUSCADOR -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-5">
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
        <table class="table table-hover mb-0" id="tabla_cursos">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{ $course->title }}</td>
                        <td>
                            @if($course->type == 'presencial')
                                <span class="badge bg-success">Presencial</span>
                            @elseif($course->type == 'e-learning')
                                <span class="badge bg-info text-dark">E-learning</span>
                            @else
                                <span class="badge bg-primary">Virtual</span>
                            @endif
                        </td>
                        <td style="white-space: nowrap;">
                            <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning me-1">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar curso?')">
                                    <i class="fas fa-trash me-1"></i>Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">
                            <i class="fas fa-book me-2"></i>No hay cursos creados
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
    document.querySelectorAll('#tabla_cursos tbody tr').forEach(row => {
        const nombre = normalizar(row.dataset.nombre || "");
        const tipoCurso = row.dataset.tipo || "";
        const matchTexto = !texto || nombre.includes(texto);
        const matchTipo = !tipo || tipoCurso === tipo;
        row.style.display = matchTexto && matchTipo ? "" : "none";
    });
}
</script>
@endsection