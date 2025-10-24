<?php

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\TripController;
use App\Http\Controllers\Conductor\ConductorTripController;
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController; 
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\Pasajero\PassengerTripController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\Auth;

// 🔹 Login principal
Route::get('/', function () {
    return redirect()->route('login');
});

// 🔹 Rutas para invitados
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

// 🔹 Rutas protegidas
Route::middleware('auth')->group(function () {

    // ✅ Dashboard según rol
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $role = $user->roles->first()->name ?? null;

        switch ($role) {
            case 'Admin':     return view('layouts.admin', compact('user'));
            case 'Conductor': return view('layouts.conductor', compact('user'));
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

    // ✅ Recursos generales
    Route::resource('/products', ProductController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/trips', TripController::class);

    // ✅ Rutas Conductor
    Route::prefix('conductor')->name('conductor.')->group(function () {
        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        Route::get('/trips', [ConductorTripController::class, 'index'])->name('trips.index');
        Route::get('/trips/create', [ConductorTripController::class, 'create'])->name('trips.create');
        Route::post('/trips', [ConductorTripController::class, 'store'])->name('trips.store');
        Route::get('/trips/{trip}/edit', [ConductorTripController::class, 'edit'])->name('trips.edit');
        Route::put('/trips/{trip}', [ConductorTripController::class, 'update'])->name('trips.update');
        Route::delete('/trips/{trip}', [ConductorTripController::class, 'destroy'])->name('trips.destroy');

        // ✅ Ruta para finalizar viaje
        Route::post('/trips/{id}/finalizar', [ConductorTripController::class, 'finalizar'])
    ->name('conductor.trips.finalizar');

    });

    // ✅ Rutas Pasajero
    Route::prefix('pasajero')->name('pasajero.')->group(function () {
        Route::get('/trips', [PassengerTripController::class, 'index'])->name('trips.index');
        Route::post('/trips/{trip}/reserve', [PassengerTripController::class, 'reserve'])->name('trips.reserve');
        Route::delete('/trips/{trip}/cancel', [PassengerTripController::class, 'cancel'])->name('trips.cancel');
        Route::get('/my-trips', [PassengerTripController::class, 'myTrips'])->name('trips.my_trips');

        // ✅ Reseñas pasajero
        Route::get('/resenas', [ReviewController::class, 'index'])->name('resenas');
        Route::post('/resenas', [ReviewController::class, 'store'])->name('resenas.store');
    });

    // ✅ Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
