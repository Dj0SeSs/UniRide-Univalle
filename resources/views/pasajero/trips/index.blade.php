@extends('layouts.pasajero')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Viajes Disponibles</h1>

    <!-- Filtros -->
    <form method="GET" action="{{ route('pasajero.trips.index') }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Fecha">
            </div>
            <div class="col-md-3">
                <input type="text" name="origin" class="form-control" value="{{ request('origin') }}" placeholder="Origen">
            </div>
            <div class="col-md-3">
                <input type="text" name="destination" class="form-control" value="{{ request('destination') }}" placeholder="Destino">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de viajes -->
    <div class="card shadow mb-4">
        <div class="card-body">
            @if($trips->isEmpty())
                <p>No hay viajes disponibles.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hora de salida</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Costo</th>
                                <th>Cupos disponibles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                            <tr>
                                <td>{{ $trip->departure_time }}</td>
                                <td>{{ $trip->origin }}</td>
                                <td>{{ $trip->destination }}</td>
                                <td>${{ $trip->price }}</td>
                                <td>{{ $trip->available_seats }}</td>
                                <td>
                                    <form action="{{ route('pasajero.trips.reserve', $trip) }}" method="POST">
                                        @csrf
                                        <button class="btn btn-sm btn-success" {{ $trip->available_seats == 0 ? 'disabled' : '' }}>
                                            Reservar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
