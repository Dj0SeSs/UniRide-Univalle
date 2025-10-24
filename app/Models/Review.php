<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'trip_id',
        'passenger_id',
        'driver_id',
        'rating',
        'comment'
    ];

    // Relación con el viaje
    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }

    // Relación con el pasajero (usuario que escribe la reseña)
    public function passenger()
    {
        return $this->belongsTo(User::class, 'passenger_id');
    }

    // Relación con el conductor
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
