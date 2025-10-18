<?php

namespace App\Http\Controllers\Conductor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;

class ConductorTripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Solo usuarios autenticados
    }

    /**
     * Mostrar todos los viajes del conductor.
     */
    public function index()
    {
        // Obtenemos solo los viajes del conductor logueado
        $trips = Auth::user()->tripsAsDriver()->orderBy('departure_time')->get();
        return view('conductor.trips.index', compact('trips'));
    }

    /**
     * Mostrar formulario para crear un nuevo viaje.
     */
    public function create()
    {
        return view('conductor.trips.create');
    }

    /**
     * Guardar nuevo viaje asociado al conductor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
        ]);

        // Crear viaje asociado al conductor
        Auth::user()->tripsAsDriver()->create($request->all());

        return redirect()->route('conductor.trips.index')
                         ->with('success', 'Viaje creado correctamente.');
    }

    /**
     * Mostrar formulario para editar viaje existente.
     */
    public function edit(Trip $trip)
    {
        // Validar que el viaje pertenezca al conductor
        if ($trip->user_id !== Auth::id()) {
            abort(403, 'No autorizado para editar este viaje.');
        }

        return view('conductor.trips.edit', compact('trip'));
    }

    /**
     * Actualizar viaje existente.
     */
    public function update(Request $request, Trip $trip)
    {
        // Validar que el viaje pertenezca al conductor
        if ($trip->user_id !== Auth::id()) {
            abort(403, 'No autorizado para actualizar este viaje.');
        }

        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
        ]);

        $trip->update($request->all());

        return redirect()->route('conductor.trips.index')
                         ->with('success', 'Viaje actualizado correctamente.');
    }

    /**
     * Eliminar viaje.
     */
    public function destroy(Trip $trip)
    {
        // Validar que el viaje pertenezca al conductor
        if ($trip->user_id !== Auth::id()) {
            abort(403, 'No autorizado para eliminar este viaje.');
        }

        $trip->delete();

        return redirect()->route('conductor.trips.index')
                         ->with('success', 'Viaje eliminado correctamente.');
    }
}
