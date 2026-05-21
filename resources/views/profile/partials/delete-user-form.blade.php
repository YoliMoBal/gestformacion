<section>
    <p class="text-muted mb-3">
        Una vez eliminada tu cuenta, todos los datos serán borrados permanentemente. 
        Asegúrate de descargar cualquier información que necesites antes de proceder.
    </p>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarCuenta">
        <i class="fas fa-trash me-2"></i>Eliminar cuenta
    </button>

    <!-- Modal confirmación -->
    <div class="modal fade" id="modalEliminarCuenta" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="fas fa-exclamation-triangle me-2"></i>Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        <p>¿Estás seguro de que quieres eliminar tu cuenta? Esta acción no se puede deshacer.</p>
                        <div class="mb-3">
                            <label class="form-label">Introduce tu contraseña para confirmar</label>
                            <input type="password" name="password" class="form-control" 
                                placeholder="Contraseña" required>
                            @if($errors->userDeletion->get('password'))
                                <div class="text-danger small">{{ $errors->userDeletion->first('password') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-2"></i>Eliminar cuenta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
