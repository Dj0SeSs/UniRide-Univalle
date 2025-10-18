<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        // Redirigir según rol
switch ($user->role) {
    case 'Admin':
        return view('layouts.admin', compact('user'));
    case 'Conductor':
        return view('layouts.conductor', compact('user'));
    case 'Pasajero':
        return view('layouts.pasajero', compact('user'));
    default:
        // Cerrar sesión y redirigir al login
        auth()->logout();
        return redirect()->route('login')->with('error', 'Tu cuenta no tiene un rol válido.');
}
    }
}


