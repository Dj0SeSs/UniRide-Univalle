@extends('layouts.pasajero')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Viajes Disponibles</h1>

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
                        <th>Acción</th>
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
                            @php
                                $hasReserved = auth()->user()->tripsAsPassenger->contains($trip->id);
                            @endphp

                            <form action="{{ route('pasajero.trips.reserve', $trip) }}" method="POST">
                                @csrf
                                <button class="btn btn-sm btn-primary"
                                    @if($trip->available_seats == 0 || $hasReserved) disabled @endif>
                                    {{ $hasReserved ? 'Reservado' : 'Reservar' }}
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
@endsection
