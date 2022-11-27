<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categoria::create([
            'nombre' => 'Estudios funciones hemáticas',
            'by' => 1,
        ]);
         Categoria::create([
            'nombre' => 'Estudios del corazón',
            'by' => 1,
        ]);
    }
}
