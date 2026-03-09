<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clase>
 */
class ClaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'fecha' => fake()->dateTimeBetween('-30 days', '+15 days')->format('Y-m-d'),
            'titulo' => 'Clase: ' . fake()->sentence(3),
        ];
    }

    public function untitled(): static
    {
        return $this->state(fn (array $attributes) => [
            'titulo' => null,
        ]);
    }
}
