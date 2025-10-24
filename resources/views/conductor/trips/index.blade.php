@extends('layouts.conductor')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Mis Viajes</h1>

    <div class="mb-3">
        <a href="{{ route('conductor.trips.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Agregar Viaje
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($trips->isEmpty())
                <p>No tienes viajes registrados.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Hora de salida</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Costo</th>
                                <th>Cupos libres</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                                @php
                                    $isPast = \Carbon\Carbon::parse($trip->departure_time)->isPast();
                                @endphp
                                <tr class="{{ $isPast ? 'table-secondary' : '' }}">
                                    <td>{{ $trip->departure_time }}</td>
                                    <td>{{ $trip->origin }}</td>
                                    <td>{{ $trip->destination }}</td>
                                    <td>{{ $trip->price }}</td>
                                    <td>{{ $trip->available_seats }}</td>
                                    <td>
                                        @if($trip->status === 'Finalizado')
                                            <span class="badge bg-secondary">Finalizado</span>
                                        @else
                                            <span class="badge bg-success">{{ $trip->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->status !== 'Finalizado')
                                            <!-- Botón para editar -->
                                            <a href="{{ route('conductor.trips.edit', $trip) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Editar
                                            </a>

                                            <!-- Botón para eliminar -->
                                            <form action="{{ route('conductor.trips.destroy', $trip) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar viaje?')">
                                                    <i class="fas fa-trash"></i> Eliminar
                                                </button>
                                            </form>

                                            <!-- Botón para marcar como Finalizado -->
                                            <form action="{{ route('conductor.trips.finalizar', $trip->id) }}" method="POST">
    @csrf
    @method('PUT')  <!-- ❌ Esto provoca el error -->
    <button type="submit">Finalizar</button>
</form>

                                        @else
                                            <span class="text-muted">No disponible</span>
                                        @endif
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
