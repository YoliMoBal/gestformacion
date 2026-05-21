<section>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        @if (session('status') === 'profile-updated')
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i>Perfil actualizado correctamente.
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control"
                value="{{ old('name', $user->name) }}" required>
            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Correo electrónico</label>
            <input type="email" name="email" class="form-control"
                value="{{ old('email', $user->email) }}" required>
            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Rol</label>
            <input type="text" class="form-control" disabled
                value="{{ $user->role === 'admin' ? 'Administrador' : 'Empleado' }}">
        </div>

        @if($user->perfilEmpleado)
        <div class="mb-3">
            <label class="form-label">Concesionario</label>
            <input type="text" class="form-control" disabled
                value="{{ $user->perfilEmpleado->codigoConcesionario->codigo ?? '-' }} — {{ $user->perfilEmpleado->codigoConcesionario->ubicacion->nombre ?? '-' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Departamento</label>
            <input type="text" class="form-control" disabled
                value="{{ $user->perfilEmpleado->departamento->nombre ?? '-' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Puesto</label>
            <input type="text" class="form-control" disabled
                value="{{ $user->perfilEmpleado->puesto->nombre ?? '-' }}">
        </div>
        @endif

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Guardar cambios
        </button>
    </form>
</section>