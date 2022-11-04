<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Departamento;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
            'nombre' => 'Administradores',
            'by' => 1
        ]);
        Departamento::create([
            'nombre' => 'Invitado',
            'by' => 1
        ]);
    }
}
