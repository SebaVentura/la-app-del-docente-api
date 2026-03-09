<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Escuela>
 */
class EscuelaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nombre' => 'Escuela ' . fake()->unique()->numberBetween(1, 9999),
            'localidad' => fake()->city(),
            'provincia' => fake()->state(),
        ];
    }

    public function withoutLocation(): static
    {
        return $this->state(fn (array $attributes) => [
            'localidad' => null,
            'provincia' => null,
        ]);
    }
}
