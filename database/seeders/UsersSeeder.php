<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '1234567890',
            'role' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'JVRC',
            'email' => 'javier.res220704@gmail.com',
            'password' => Hash::make('J22r07c04'),
            'phone' => '8713814026',
            'role' => 2,
            'status' => 1,
        ]);
    }
}
