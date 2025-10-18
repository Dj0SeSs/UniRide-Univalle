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

    // Relación con el conductor
    public function conductor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user() {
    return $this->belongsTo(User::class);
    }

    public function passengers()
    {
    return $this->belongsToMany(User::class)->withPivot('created_at')->withTimestamps();
    }



}
