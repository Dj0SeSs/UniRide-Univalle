<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class PassengerTripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar viajes disponibles con filtros
     */
    public function index(Request $request)
    {
        $query = Trip::query()->where('available_seats', '>', 0);

        if ($request->filled('date')) {
            $query->whereDate('departure_time', $request->date);
        }
        if ($request->filled('origin')) {
            $query->where('origin', 'like', "%{$request->origin}%");
        }
        if ($request->filled('destination')) {
            $query->where('destination', 'like', "%{$request->destination}%");
        }

        $trips = $query->orderBy('departure_time')->get();

        return view('pasajero.trips.index', compact('trips'));
    }

    /**
     * Reservar un viaje
     */
    public function reserve(Trip $trip)
    {
        $user = Auth::user();

        // Verificar que haya cupos disponibles
        if ($trip->available_seats <= 0) {
            return redirect()->back()->with('error', 'No hay cupos disponibles en este viaje.');
        }

        // Evitar duplicar reservas
        if ($user->tripsAsPassenger->contains($trip->id)) {
            return redirect()->back()->with('error', 'Ya reservaste este viaje.');
        }

        // Agregar al pivot y disminuir cupos
        $user->tripsAsPassenger()->attach($trip->id);
        $trip->decrement('available_seats');

        return redirect()->back()->with('success', 'Viaje reservado correctamente.');
    }

    /**
     * Mostrar los viajes reservados por el pasajero
     */
    public function myTrips()
    {
        $user = Auth::user();
        $myTrips = $user->tripsAsPassenger()->orderBy('departure_time')->get();

        return view('pasajero.trips.my_trips', compact('myTrips'));
    }

    /**
     * Cancelar una reserva
     */
    public function cancel(Trip $trip)
    {
        $user = Auth::user();

        if (!$user->tripsAsPassenger->contains($trip->id)) {
            return redirect()->back()->with('error', 'No tienes este viaje reservado.');
        }

        // Eliminar del pivot y aumentar cupos
        $user->tripsAsPassenger()->detach($trip->id);
        $trip->increment('available_seats');

        return redirect()->back()->with('success', 'Reserva cancelada correctamente.');
    }
}
