<section>
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        @if (session('status') === 'password-updated')
            <div class="alert alert-success mb-3">
                <i class="fas fa-check-circle me-2"></i>Contraseña actualizada correctamente.
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Contraseña actual</label>
            <input type="password" name="current_password" class="form-control"
                autocomplete="current-password">
            @if($errors->updatePassword->get('current_password'))
                <div class="text-danger small">{{ $errors->updatePassword->first('current_password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Nueva contraseña</label>
            <input type="password" name="password" class="form-control"
                autocomplete="new-password">
            @if($errors->updatePassword->get('password'))
                <div class="text-danger small">{{ $errors->updatePassword->first('password') }}</div>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="form-control"
                autocomplete="new-password">
            @if($errors->updatePassword->get('password_confirmation'))
                <div class="text-danger small">{{ $errors->updatePassword->first('password_confirmation') }}</div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-2"></i>Guardar contraseña
        </button>
    </form>
</section>
