@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Pasajero</h1>
    <p>Bienvenido, {{ Auth::user()->name }}. Aquí puedes ver tus viajes y detalles de reserva.</p>
    {{-- Agrega elementos específicos para pasajero si quieres --}}
    <p>ID de usuario: {{ Auth::id() }}</p>
<p>Nombre: {{ Auth::user()->name }}</p>
<p>Rol: {{ Auth::user()->role }}</p>

</div>
@endsection
