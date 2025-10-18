<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // Middleware interno para validar que solo Conductor acceda
        $this->middleware(function ($request, $next) {
            $user = auth()->user();
            $role = $user->roles->first()->name ?? null;

            if ($role !== 'Conductor') {
                abort(403, 'Acceso denegado');
            }

            return $next($request);
        });
    }

    // Mostrar todos los vehículos del conductor
    public function index()
    {
        $vehicles = auth()->user()->vehicles;
        return view('conductor.vehicles.index', compact('vehicles'));
    }

    // Mostrar formulario para agregar nuevo vehículo
    public function create()
    {
        return view('conductor.vehicles.create');
    }

    // Guardar nuevo vehículo
    public function store(Request $request)
    {
        $request->validate([
            'plate' => 'required|unique:vehicles,plate',
            'brand' => 'required',
            'model' => 'required',
            'color' => 'nullable',
        ]);

        auth()->user()->vehicles()->create($request->all());

        return redirect()->route('conductor.vehicles.index')
                         ->with('success', 'Vehículo agregado correctamente.');
    }

    // Mostrar formulario para editar vehículo existente
    public function edit(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);
        return view('conductor.vehicles.edit', compact('vehicle'));
    }

    // Actualizar vehículo
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);

        $request->validate([
            'plate' => 'required|unique:vehicles,plate,' . $vehicle->id,
            'brand' => 'required',
            'model' => 'required',
            'color' => 'nullable',
        ]);

        $vehicle->update($request->all());

        return redirect()->route('conductor.vehicles.index')
                         ->with('success', 'Vehículo actualizado correctamente.');
    }

    // Eliminar vehículo
    public function destroy(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);

        $vehicle->delete();
        return redirect()->route('conductor.vehicles.index')
                         ->with('success', 'Vehículo eliminado correctamente.');
    }

    // Validar que el vehículo pertenece al conductor autenticado
    private function authorizeVehicle(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== auth()->id()) {
            abort(403, 'Acceso denegado');
        }
    }
}
