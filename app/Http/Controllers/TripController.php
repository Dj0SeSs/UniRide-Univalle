<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;

class TripController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $trips = Trip::orderBy('departure_time')->get();
        return view('trips.index', compact('trips'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
        ]);

        Trip::create($request->all());

        return redirect()->route('trips.index')->with('success', 'Viaje creado correctamente.');
    }

    public function update(Request $request, Trip $trip)
    {
        $request->validate([
            'departure_time' => 'required|date',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'available_seats' => 'required|integer|min:0',
        ]);

        $trip->update($request->all());

        return redirect()->route('trips.index')->with('success', 'Viaje actualizado correctamente.');
    }

    public function destroy(Trip $trip)
    {
        $trip->delete();
        return redirect()->route('trips.index')->with('success', 'Viaje eliminado correctamente.');
    }
}
