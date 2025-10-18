<?php

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\TripController;
use App\Http\Controllers\Conductor\ConductorTripController; // <-- Conductor trips
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VehicleController; // <-- Vehículos conductor
use App\Http\Controllers\Pasajero\PassengerTripController;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Auth;

// Login principal
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas para invitados
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);

    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);

    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Rutas protegidas (solo usuarios autenticados)
Route::middleware('auth')->group(function () {

    // Dashboard según rol
   Route::get('/dashboard', function () {
    $user = auth()->user();
    $role = $user->roles->first()->name ?? null;

    switch ($role) {
        case 'Admin':
            return view('layouts.admin', compact('user'));
        case 'Conductor':
            return view('layouts.conductor', compact('user'));
        case 'Pasajero':
    $trips = \App\Models\Trip::where('available_seats', '>', 0)
                ->orderBy('departure_time')
                ->get();
    return view('pasajero.trips.dashboard', compact('user', 'trips'));

        default:
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tu cuenta no tiene un rol válido.');
    }
})->name('dashboard');


    // Recursos protegidos
    Route::resource('/products', ProductController::class);
    Route::resource('/users', UserController::class);
    
    // CRUD de viajes (solo Admin)
    Route::resource('/trips', TripController::class);

    // CRUD de vehículos y viajes (solo Conductor)
    Route::prefix('conductor')->middleware(['auth'])->group(function () {
        // Vehículos
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('conductor.vehicles.index');
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('conductor.vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('conductor.vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('conductor.vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('conductor.vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('conductor.vehicles.destroy');

        // Viajes
        Route::get('/trips', [ConductorTripController::class, 'index'])->name('conductor.trips.index');
        Route::get('/trips/create', [ConductorTripController::class, 'create'])->name('conductor.trips.create');
        Route::post('/trips', [ConductorTripController::class, 'store'])->name('conductor.trips.store');
        Route::get('/trips/{trip}/edit', [ConductorTripController::class, 'edit'])->name('conductor.trips.edit');
        Route::put('/trips/{trip}', [ConductorTripController::class, 'update'])->name('conductor.trips.update');
        Route::delete('/trips/{trip}', [ConductorTripController::class, 'destroy'])->name('conductor.trips.destroy');
    });

    // CRUD de viajes para pasajero
Route::prefix('pasajero')->middleware(['auth'])->group(function () {
    // Ver todos los viajes disponibles con filtros
    Route::get('/trips', [PassengerTripController::class, 'index'])->name('pasajero.trips.index');

    // Reservar un viaje
    Route::post('/trips/{trip}/reserve', [PassengerTripController::class, 'reserve'])->name('pasajero.trips.reserve');

    // Cancelar un viaje reservado
    Route::delete('/trips/{trip}/cancel', [PassengerTripController::class, 'cancel'])->name('pasajero.trips.cancel');

    // Mis viajes
    Route::get('/my-trips', [PassengerTripController::class, 'myTrips'])->name('pasajero.trips.my_trips');

});


    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
