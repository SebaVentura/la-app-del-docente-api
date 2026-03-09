<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PerfilDocente>
 */
class PerfilDocenteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nombres' => fake()->firstName(),
            'apellidos' => fake()->lastName(),
            'dni' => (string) fake()->numberBetween(20000000, 49999999),
            'cuil' => sprintf('20-%08d-%d', fake()->numberBetween(20000000, 49999999), fake()->numberBetween(0, 9)),
            'domicilio' => fake()->streetAddress(),
            'localidad' => fake()->city(),
            'provincia' => fake()->state(),
            'telefono' => fake()->phoneNumber(),
        ];
    }

    public function minimal(): static
    {
        return $this->state(fn (array $attributes) => [
            'dni' => null,
            'cuil' => null,
            'domicilio' => null,
            'telefono' => null,
        ]);
    }
}
