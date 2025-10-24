@extends('layouts.pasajero')

@section('content')
<div class="container mt-4">
    <h4>⭐ Reseñar mis viajes realizados</h4>
    <hr>

    <!-- ✅ Mostrar mensajes -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- ✅ Formulario para reseñar -->
    <form action="{{ route('pasajero.resenas.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="tripSelect" class="form-label">Selecciona un viaje:</label>
            <select id="tripSelect" name="trip_id" class="form-control" required>
                <option value="" selected disabled>-- Selecciona un viaje --</option>
                @foreach($trips as $trip)
                    <option 
                        value="{{ $trip->id }}" 
                        data-driver="{{ $trip->driver->id }}">
                        {{ $trip->origin }} → {{ $trip->destination }} ({{ $trip->departure_time }}) 
                        - Conductor: {{ $trip->driver->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="driver_id" id="driver_id">

        <!-- Calificación -->
        <label class="form-label">Tu calificación:</label>
        <div id="stars">
            @for ($i = 5; $i >= 1; $i--)
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                <label for="star{{ $i }}">⭐</label>
            @endfor
        </div>

        <textarea name="comment" class="form-control mt-2" placeholder="Escribe tu reseña..." rows="3"></textarea>

        <button type="submit" class="btn btn-primary w-100 mt-3">Publicar reseña</button>
    </form>

    <!-- ✅ Mostrar reseñas -->
    <div class="mt-4" id="reviewsList">
        <h5>Mis reseñas publicadas</h5>
        @if($reviews->isEmpty())
            <p class="text-muted">Aún no has publicado ninguna reseña.</p>
        @else
            @foreach($reviews as $review)
                <div class="card p-3 mt-2">
                    <strong>⭐ {{ $review->rating }} estrellas</strong><br>
                    <small>👤 Conductor: <b>{{ $review->driver->name }}</b></small><br>
                    <small>🚗 Viaje ID: {{ $review->trip_id }}</small>
                    <p class="mt-2">{{ $review->comment }}</p>
                </div>
            @endforeach
        @endif
    </div>
</div>

<script>
// ✅ Asignar automáticamente el driver_id cuando selecciona viaje
document.getElementById('tripSelect').addEventListener('change', function () {
    const driverId = this.options[this.selectedIndex].getAttribute('data-driver');
    document.getElementById('driver_id').value = driverId;
});
</script>
@endsection
