<?php

namespace Database\Seeders;

use App\Models\CRUD;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CRUDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $registro1 = CRUD::create([
            'nombre' => 'Agustin',
            'apellido_paterno' => 'Escobedo',
            'apellido_materno' => 'Vargas',
            'edad' => 20,
            'correo' => 'agustin@gmail.com',
            'telefono' => '5555555555',
        ]);
        $registro2 = CRUD::create([
            'nombre' => 'Antonio',
            'apellido_paterno' => 'Luna',
            'apellido_materno' => 'Vazquez',
            'edad' => 22,
            'correo' => 'antonio@gmail.com',
            'telefono' => '5555555555',
        ]);
        $registro3 = CRUD::create([
            'nombre' => 'Juanito',
            'apellido_paterno' => 'Sanchez',
            'apellido_materno' => 'Hernandez',
            'edad' => 25,
            'correo' => 'juanito@gmail.com',
            'telefono' => '5555555555',
        ]);
    }
}
