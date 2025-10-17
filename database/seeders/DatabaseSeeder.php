<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class, // 👈 añadimos el seeder de roles aquí
            AdminUserSeeder::class,
            ProductSeeder::class,
            RoleSeeder::class, 
            DemoUsersSeeder::class,
        ]);
    }
}




