<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Categoria;
use App\Models\Tipoventa;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            DepartamentoSeeder::class,
            PuestoSeeder::class,
            RoleAndPermissionSeeder::class,
            GrupoSeeder::class,
            CategoriaSeeder::class,
            TipoventaSeeder::class,
            UserSeeder::class,
        ]);
    }
}
