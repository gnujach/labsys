<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Paciente>
 */
class PacienteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => strtoupper(fake()->name),
            'ap1' => strtoupper(fake()->lastName),
            'ap2' => strtoupper(fake()->lastName),
            'tel' => 4686896385,
            'correo' => strtoupper(fake()->email),
            'edad' => fake()->randomElement([23,34,43,56,78]),
            'genero' => fake()->randomElement(['Másculino','Femenino']),
            'direccion' => fake()->address,
            'activo' => fake()->boolean,
            'by' => User::factory()
        ];
    }
}
