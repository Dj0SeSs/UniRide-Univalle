<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* ============================
     * ✅ RELACIONES
     * ============================ */

    // ✅ Relación muchos a muchos con roles
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // ✅ Verificar si el usuario tiene un rol específico
    public function hasRole($role)
    {
        return $this->roles->contains('name', $role);
    }

    // ✅ Vehículos registrados por el usuario (si es conductor)
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    // ✅ Viajes donde el usuario fue PASAJERO (tabla pivote trip_user)
    public function tripsAsPassenger()
    {
        return $this->belongsToMany(Trip::class, 'trip_user', 'user_id', 'trip_id')
                    ->withTimestamps();
    }

    // ✅ Alias para acceder a los viajes como pasajero usando $user->trips
    public function trips()
    {
        return $this->tripsAsPassenger();
    }

    // ✅ Viajes donde el usuario es CONDUCTOR
    // ⚠ Asegúrate de que en tu tabla `trips`, el conductor se almacene en la columna 'user_id'
    public function tripsAsDriver()
    {
        return $this->hasMany(Trip::class, 'user_id');
    }
}
