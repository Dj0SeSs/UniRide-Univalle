@extends('layouts.conductor')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Agregar Viaje</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('conductor.trips.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="departure_time" class="form-label">Hora de salida</label>
                    <input type="datetime-local" class="form-control @error('departure_time') is-invalid @enderror" name="departure_time" value="{{ old('departure_time') }}" required>
                    @error('departure_time')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="origin" class="form-label">Origen</label>
                    <input type="text" class="form-control @error('origin') is-invalid @enderror" name="origin" value="{{ old('origin') }}" required>
                    @error('origin')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="destination" class="form-label">Destino</label>
                    <input type="text" class="form-control @error('destination') is-invalid @enderror" name="destination" value="{{ old('destination') }}" required>
                    @error('destination')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label">Costo</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price') }}" step="0.01" required>
                    @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="available_seats" class="form-label">Cupos libres</label>
                    <input type="number" class="form-control @error('available_seats') is-invalid @enderror" name="available_seats" value="{{ old('available_seats') }}" required>
                    @error('available_seats')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Agregar Viaje</button>
                <a href="{{ route('conductor.trips.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
