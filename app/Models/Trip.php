<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',           // conductor
        'departure_time',
        'origin',
        'destination',
        'price',
        'available_seats',
        'status',            // opcional: Pendiente o Finalizado
    ];

    // ✅ Relación con el conductor (mejor usar el nombre estándar: driver)
    public function driver()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ❌ Puedes eliminar este, es redundante y causa confusión
    // public function user() {
    //     return $this->belongsTo(User::class);
    // }

    // ✅ Pasajeros del viaje (tabla pivote trip_user)
    public function passengers()
    {
        return $this->belongsToMany(User::class, 'trip_user', 'trip_id', 'user_id')
                    ->withTimestamps();
    }

    // ✅ Reseñas relacionadas con este viaje (opcional pero útil)
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
