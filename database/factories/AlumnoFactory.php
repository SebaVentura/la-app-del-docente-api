<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'apellidos' => fake()->lastName(),
            'nombres' => fake()->firstName(),
            'legajo' => (string) fake()->unique()->numberBetween(1000, 999999),
        ];
    }

    public function withoutLegajo(): static
    {
        return $this->state(fn (array $attributes) => [
            'legajo' => null,
        ]);
    }
}
