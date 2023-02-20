<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::create([
            'nombre' => 'Administrador'
        ]);

        Rol::create([
            'nombre' => 'Moderador'
        ]);

        Rol::create([
            'nombre' => 'Usuario'
        ]);
    }
}
