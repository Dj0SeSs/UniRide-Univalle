@extends('layouts.admin')

@section('titulo')
<span>Viajes</span>
<a href="" class="btn btn-primary btn-circle" data-toggle="modal" data-target="#createMdl">
    <i class="fas fa-plus"></i>
</a>
@endsection

@section('contenido')

@include('trips.modals.create')
@include('trips.modals.update')
@include('trips.modals.delete')

<div class="card">
    <div class="card-body">
        <table id="dt-trips" class="table table-striped table-bordered dts">
            <thead>
            <tr class="text-center">
                <th>Hora de Salida</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Costo</th>
                <th>Cupos Libres</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
            @foreach($trips as $trip)
            <tr class="text-center">
                <td>{{ $trip->departure_time }}</td>
                <td>{{ $trip->origin }}</td>
                <td>{{ $trip->destination }}</td>
                <td>${{ $trip->price }}</td>
                <td>{{ $trip->available_seats }}</td>
                <td>
                    <a href="#" class="edit-form-data" data-toggle="modal" data-target="#editMdl"
                       onclick="editTrip({{ $trip }})">
                        <i class="far fa-edit"></i>
                    </a>

                    <a href="#" class="delete-form-data" data-toggle="modal" data-target="#deleteMdl"
                       data-id="{{ $trip->id }}">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
function editTrip(trip){
    $("#editTripFrm").attr('action', `/trips/${trip.id}`);
    $("#editTripFrm #departure_time").val(trip.departure_time);
    $("#editTripFrm #origin").val(trip.origin);
    $("#editTripFrm #destination").val(trip.destination);
    $("#editTripFrm #price").val(trip.price);
    $("#editTripFrm #available_seats").val(trip.available_seats);
}

// Modal para eliminar correctamente
$('#deleteMdl').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var tripId = button.data('id'); // <- Muy importante
    $('#deleteTripFrm').attr('action', `/trips/${tripId}`);
});

// Inicializar DataTables
$(document).ready(function(){
    $('#dt-trips').DataTable({
        "ordering": true,
        "searching": true
    });
});
</script>
@endpush
