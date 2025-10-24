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
        $request->validate([
            'trip_id'   => 'required|exists:trips,id',
            'driver_id' => 'required|exists:users,id',
            'rating'    => 'required|integer|min(1)|max(5)',
            'comment'   => 'nullable|string|max:500'
        ]);

        $user = Auth::user();

        // ✅ Verificar que el usuario fue pasajero de ese viaje y que esté finalizado
        $esPasajero = $user->tripsAsPassenger()
            ->where('trips.id', $request->trip_id)
            ->where('trips.status', 'Finalizado') // 👈 Aseguramos que solo reseñe viajes finalizados
            ->exists();

        if (!$esPasajero) {
            return back()->with('error', '⚠ No puedes reseñar un viaje que no realizaste o que no ha finalizado.');
        }

        // ✅ Evitar duplicar reseña para el mismo viaje
        $yaExiste = Review::where('trip_id', $request->trip_id)
            ->where('passenger_id', $user->id)
            ->exists();

        if ($yaExiste) {
            return back()->with('error', '⚠ Ya has calificado este viaje.');
        }

        // ✅ Crear y guardar reseña
        Review::create([
            'trip_id'      => $request->trip_id,
            'passenger_id' => $user->id,
            'driver_id'    => $request->driver_id,
            'rating'       => $request->rating,
            'comment'      => $request->comment,
        ]);

        return back()->with('success', '✅ Reseña publicada exitosamente.');
    }
}
