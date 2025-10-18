<div class="modal fade" id="createMdl" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('trips.store') }}" method="POST">
        @csrf
        <div class="modal-header"><h5>Nuevo Viaje</h5></div>
        <div class="modal-body">
            <input type="datetime-local" name="departure_time" class="form-control mb-2" required>
            <input type="text" name="origin" class="form-control mb-2" placeholder="Origen" required>
            <input type="text" name="destination" class="form-control mb-2" placeholder="Destino" required>
            <input type="number" step="0.01" name="price" class="form-control mb-2" placeholder="Costo" required>
            <input type="number" name="available_seats" class="form-control mb-2" placeholder="Cupos libres" required>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>
