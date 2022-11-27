<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipoventa;

class TipoventaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipoventa::create([
            'nombre' => 'Unidad',
            'by' => 1,
        ]);
        Tipoventa::create([
            'nombre' => 'Paquete',
            'by' => 1,
        ]);
    }
}
