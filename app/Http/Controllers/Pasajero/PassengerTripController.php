<?php

namespace App\Http\Controllers\Pasajero;

use App\Http\Controllers\Controller;
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
     * Mostrar todos los viajes disponibles
     * Posibilidad de filtrar por fecha, origen o destino
     */
    public function index(Request $request)
    {
        $query = Trip::query();

        // Filtrar por fecha si se proporciona
        if ($request->filled('date')) {
            $query->whereDate('departure_time', $request->date);
        }

        // Filtrar por origen
        if ($request->filled('origin')) {
            $query->where('origin', 'like', "%{$request->origin}%");
        }

        // Filtrar por destino
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

        // Revisar si ya está reservado
        if ($user->tripsAsPassenger()->where('trip_id', $trip->id)->exists()) {
            return redirect()->back()->with('error', 'Ya reservaste este viaje.');
        }

        // Revisar que haya cupos disponibles
        if ($trip->available_seats <= 0) {
            return redirect()->back()->with('error', 'No hay cupos disponibles.');
        }

        $user->tripsAsPassenger()->attach($trip->id);

        // Reducir cupo disponible
        $trip->decrement('available_seats');

        return redirect()->back()->with('success', 'Viaje reservado correctamente.');
    }

    /**
     * Cancelar un viaje reservado
     */
    public function cancel(Trip $trip)
    {
        $user = Auth::user();

        if (!$user->tripsAsPassenger()->where('trip_id', $trip->id)->exists()) {
            return redirect()->back()->with('error', 'No tienes este viaje reservado.');
        }

        $user->tripsAsPassenger()->detach($trip->id);

        // Aumentar cupo disponible
        $trip->increment('available_seats');

        return redirect()->back()->with('success', 'Viaje cancelado correctamente.');
    }

    /**
     * Mostrar los viajes del pasajero
     */
    public function myTrips()
{
    $myTrips = Auth::user()->tripsAsPassenger()->orderBy('departure_time')->get();
    return view('pasajero.trips.my_trips', compact('myTrips'));
}

}
