<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grupo;

class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Grupo::create([
            'nombre' => 'Todas las Personas',
            'by' => 1,
        ]);
        Grupo::create([
            'nombre' => 'Mujeres y Hombres Adultos',
            'by' => 1,
        ]);
    }
}
