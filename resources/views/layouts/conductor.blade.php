@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Dashboard Conductor</h1>
    <p>Bienvenido, {{ Auth::user()->name }}. Aquí puedes ver tu información y rutas asignadas.</p>
    {{-- Agrega elementos específicos para conductor si quieres --}}
</div>
@endsection
