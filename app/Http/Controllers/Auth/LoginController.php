<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Donde redirigir después del login
     */
    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        // Middleware 'guest' solo se aplica si NO hay sesión activa
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirige al dashboard según el rol después del login
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->roles || $user->roles->isEmpty()) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tu cuenta no tiene un rol asignado.');
        }

        // Todos los usuarios válidos van al mismo dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Redirige al login después de cerrar sesión y borra la sesión 'remember me'
     */
    protected function loggedOut(Request $request)
    {
        $request->session()->invalidate(); // invalida la sesión
        $request->session()->regenerateToken(); // regenera el token CSRF
        return redirect()->route('login');
    }
}
