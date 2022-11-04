<?php

namespace Database\Seeders;

use \App\Models\Puesto;

use Illuminate\Database\Seeder;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Puesto::create([
            'nombre' => 'Administrador',
            'by' => 1
        ]);
        Puesto::create([
            'nombre' => 'Invitado',
            'by' => 1
        ]);
    }
}
