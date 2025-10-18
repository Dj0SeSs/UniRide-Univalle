<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Pasajero
        $passenger = User::firstOrCreate(
            ['email' => 'pasajero@uniride.com'],
            [
                'name' => 'Pasajero Demo',
                'password' => Hash::make('pass123'),
            ]
        );

        $passengerRole = Role::where('name', 'Pasajero')->first();
        if ($passengerRole) {
            $passenger->roles()->syncWithoutDetaching([$passengerRole->id]);
        }

        // Conductor
        $driver = User::firstOrCreate(
            ['email' => 'conductor@uniride.com'],
            [
                'name' => 'Conductor Demo',
                'password' => Hash::make('drive123'),
            ]
        );

        $driverRole = Role::where('name', 'Conductor')->first();
        if ($driverRole) {
            $driver->roles()->syncWithoutDetaching([$driverRole->id]);
        }
    }
}
