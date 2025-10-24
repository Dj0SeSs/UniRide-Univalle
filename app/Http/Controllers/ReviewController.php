<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReviewController extends Controller
{
    /**
     * ✅ Mostrar la vista de reseñas + viajes realizados por el pasajero
     */
    public function index()
    {
        $user = Auth::user();

        // ✅ Viajes donde el usuario fue pasajero y están finalizados
        $trips = $user->tripsAsPassenger()
            ->where('trips.status', 'Finalizado')   // Incluimos tabla trips para evitar ambigüedad
            ->with('driver')                        // Relación: Trip->driver()
            ->get();

        // ✅ Reseñas hechas por el usuario autenticado
        $reviews = Review::where('passenger_id', $user->id)
            ->with(['driver', 'trip'])             // Para mostrar nombres del conductor y datos del viaje
            ->get();

        return view('pasajero.resenas.resenas', compact('trips', 'reviews'));
    }

    /**
     * ✅ Guardar la reseña en la base de datos
     */
    public function store(Request $request)
{
    // ✅ Validación correcta (sin min(1), usando min:1)
    $request->validate([
        'trip_id'   => 'required|exists:trips,id',
        'driver_id' => 'required|exists:users,id',
        'rating'    => 'required|integer|min:1|max:5',
        'comment'   => 'nullable|string|min:1|max:500',
    ]);

    $user = Auth::user();

    // ✅ Verificar si el usuario fue pasajero de ese viaje y además está finalizado
    $esPasajero = $user->tripsAsPassenger()
        ->where('trips.id', $request->trip_id)
        ->where('trips.status', 'Finalizado')
        ->exists();

    if (!$esPasajero) {
        return back()->with('error', '⚠ No puedes reseñar un viaje que no realizaste o que todavía no ha finalizado.');
    }

    // ✅ Verificar que no haya otra reseña del mismo pasajero en ese viaje
    $yaExiste = Review::where('trip_id', $request->trip_id)
        ->where('passenger_id', $user->id)
        ->exists();

    if ($yaExiste) {
        return back()->with('error', '⚠ Ya has calificado este viaje anteriormente.');
    }

    // ✅ Guardar la reseña
    Review::create([
        'trip_id'      => $request->trip_id,
        'passenger_id' => $user->id,          // pasajero autenticado
        'driver_id'    => $request->driver_id,
        'rating'       => $request->rating,
        'comment'      => $request->comment,
    ]);

    return back()->with('success', '✅ Reseña publicada exitosamente.');
}

}
