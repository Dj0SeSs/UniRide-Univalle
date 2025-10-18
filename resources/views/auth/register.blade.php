@extends('layouts.app')

@section('content')
<div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nombre -->
                            <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                    <input id="name" type="text" 
                                           class="form-control form-control-user @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                           placeholder="Full Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <input id="email" type="email" 
                                       class="form-control form-control-user @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" required autocomplete="email"
                                       placeholder="Email Address">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Contraseña -->
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input id="password" type="password" 
                                           class="form-control form-control-user @error('password') is-invalid @enderror" 
                                           name="password" required autocomplete="new-password" placeholder="Password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-sm-6">
                                    <input id="password-confirm" type="password" class="form-control form-control-user"
                                           name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                </div>
                            </div>

                            <!-- Rol -->
                            <div class="form-group">
                                <select id="role" name="role" 
                                        class="form-control form-control-user @error('role') is-invalid @enderror" required>
                                    <option value="">-- Select Role --</option>
                                    <option value="Pasajero" {{ old('role') == 'Pasajero' ? 'selected' : '' }}>Pasajero</option>
                                    <option value="Conductor" {{ old('role') == 'Conductor' ? 'selected' : '' }}>Conductor</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Vehículos (solo Conductor) -->
                            <div id="vehicles-container" style="display: none;">
                                <hr>
                                <h5 class="text-center">Vehículos</h5>
                                <div id="vehicle-list"></div>
                                <div class="row mb-3">
                                    <div class="col-md-12 text-right">
                                        <button type="button" class="btn btn-secondary btn-sm" id="add-vehicle">Agregar vehículo</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Botón Registrar -->
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>

                            <hr>

                            <!-- Opciones sociales -->
                            <a href="#" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> Register with Google
                            </a>
                            <a href="#" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                            </a>
                        </form>

                        <hr>
                        <div class="text-center">
                            <a class="small" href="#">Forgot Password?</a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
const roleSelect = document.getElementById('role');
const vehiclesContainer = document.getElementById('vehicles-container');
let vehicleIndex = 0;

function createVehicleItem(vehicle = {}) {
    const div = document.createElement('div');
    div.classList.add('vehicle-item', 'row', 'mb-3');
    div.innerHTML = `
        <div class="col-md-6">
            <input type="text" name="vehicles[${vehicleIndex}][plate]" class="form-control mb-1" placeholder="Placa" value="${vehicle.plate ?? ''}" required>
            <input type="text" name="vehicles[${vehicleIndex}][brand]" class="form-control mb-1" placeholder="Marca" value="${vehicle.brand ?? ''}" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="vehicles[${vehicleIndex}][model]" class="form-control mb-1" placeholder="Modelo" value="${vehicle.model ?? ''}" required>
            <input type="text" name="vehicles[${vehicleIndex}][color]" class="form-control mb-1" placeholder="Color" value="${vehicle.color ?? ''}">
        </div>
        <div class="col-md-12 text-right">
            <button type="button" class="btn btn-danger btn-sm remove-vehicle">Eliminar</button>
        </div>
    `;
    vehicleIndex++;
    return div;
}

// Mostrar/ocultar campos de vehículos
roleSelect.addEventListener('change', function() {
    vehiclesContainer.style.display = this.value === 'Conductor' ? 'block' : 'none';
});

// Agregar vehículo
document.getElementById('add-vehicle').addEventListener('click', function() {
    document.getElementById('vehicle-list').appendChild(createVehicleItem());
});

// Eliminar vehículo
document.addEventListener('click', function(e) {
    if(e.target.classList.contains('remove-vehicle')) {
        e.target.closest('.vehicle-item').remove();
    }
});

// Restaurar vehículos tras error de validación
@if(old('vehicles'))
    vehiclesContainer.style.display = 'block';
    const oldVehicles = @json(old('vehicles'));
    const vehicleList = document.getElementById('vehicle-list');
    oldVehicles.forEach(v => {
        vehicleList.appendChild(createVehicleItem(v));
    });
@endif
</script>
@endpush
@endsection
