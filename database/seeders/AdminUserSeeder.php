<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar o crear el usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@uniride.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('admin123'),
            ]
        );

        // Buscar el rol Admin
        $adminRole = Role::where('name', 'Admin')->first();

        // Asignar el rol
        if ($adminRole) {
            $admin->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}
