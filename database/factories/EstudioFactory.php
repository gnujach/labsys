<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Estudio>
 */
class EstudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => fake()->name,
            'clave' =>  Str::random(4),
            'precio_mostrador'=> fake()->randomDigitNotZero(),
            'precio_preferencial'=> fake()->randomDigitNotZero(),
            'costo'=> fake()->randomDigitNotZero(),
            'ganancia'=> fake()->randomDigitNotZero(),
            'tipoventa_id'=> 1,
            'grupo_id'=> 1,
            'categoria_id'=> 1,
            'corte_id'=>1,
            'activo'=> true,
            'by' => User::factory()
        ];

    }
}
