<div class="modal fade" id="deleteMdl" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="deleteTripFrm" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal-header"><h5>Eliminar Viaje</h5></div>
        <div class="modal-body">
            ¿Desea eliminar este viaje?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div>
