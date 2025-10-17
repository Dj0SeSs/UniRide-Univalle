<div class="modal fade" id="editMdl" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserFrm" method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Editar Usuario</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit-name">Nombre</label>
                        <input name="name" id="edit-name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="edit-roles">Roles</label>
                        <select name="roles[]" id="edit-roles" class="form-control" multiple required>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning text-white">Actualizar</button>
                </div>
            </div>
        </form>
    </div>
</div>
