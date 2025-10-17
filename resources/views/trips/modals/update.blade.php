<div class="modal fade" id="editMdl" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="editTripFrm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-header"><h5>Editar Viaje</h5></div>
        <div class="modal-body">
            <input type="datetime-local" name="departure_time" id="departure_time" class="form-control mb-2" required>
            <input type="text" name="origin" id="origin" class="form-control mb-2" required>
            <input type="text" name="destination" id="destination" class="form-control mb-2" required>
            <input type="number" step="0.01" name="price" id="price" class="form-control mb-2" required>
            <input type="number" name="available_seats" id="available_seats" class="form-control mb-2" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </form>
    </div>
  </div>
</div>
