<div class="modal fade" id="deleteMdl" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="deleteUserFrm" method="POST">
            @csrf
            @method('DELETE')

            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Eliminar Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="mb-0">¿Seguro que deseas eliminar este usuario? Esta acción no se puede deshacer.</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </form>
    </div>
</div>
