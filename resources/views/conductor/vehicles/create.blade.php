@extends('layouts.conductor')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Agregar Vehículo</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="{{ route('conductor.vehicles.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="plate">Placa</label>
                    <input type="text" name="plate" id="plate" class="form-control" value="{{ old('plate') }}" required>
                </div>

                <div class="form-group">
                    <label for="brand">Marca</label>
                    <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand') }}" required>
                </div>

                <div class="form-group">
                    <label for="model">Modelo</label>
                    <input type="text" name="model" id="model" class="form-control" value="{{ old('model') }}" required>
                </div>

                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="color" id="color" class="form-control" value="{{ old('color') }}">
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('conductor.vehicles.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection
