<?php 

use App\Http\Controllers\HomeController; 
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\TripController; // <-- Agregamos
use App\Http\Controllers\Auth\LoginController; 
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route; 

// Login principal
Route::get('/', function () {
    return view('auth.login');
})->name('login');

// Ruta temporal para register (redirige al login)
Route::get('/register', function() {
    return redirect()->route('login');
})->name('register');

// Rutas para invitados
Route::middleware('guest')->group(function () {
    Auth::routes(['register' => false]); // seguimos deshabilitando registro real
});

// Rutas protegidas (solo usuarios autenticados)
Route::middleware('auth')->group(function () {

    // Dashboard según rol
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Tomamos el primer rol asignado
        $role = $user->roles->first()->name ?? null;

        switch ($role) {
            case 'Admin':
                return view('layouts.admin', compact('user'));
            case 'Conductor':
                return view('layouts.conductor', compact('user'));
            case 'Pasajero':
                return view('layouts.pasajero', compact('user'));
            default:
                auth()->logout();
                return redirect()->route('login')->with('error', 'Tu cuenta no tiene un rol válido.');
        }
    })->name('dashboard');

    // Recursos protegidos
    Route::resource('/products', ProductController::class);
    Route::resource('/users', UserController::class);
    
    // CRUD de viajes (solo Admin por ahora)
    Route::resource('/trips', TripController::class);

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
