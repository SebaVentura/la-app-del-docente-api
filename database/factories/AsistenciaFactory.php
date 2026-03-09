<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Clase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Asistencia>
 */
class AsistenciaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'clase_id' => Clase::factory(),
            'alumno_id' => Alumno::factory(),
            'estado' => fake()->randomElement(['present', 'absent', 'late', 'justified']),
            'comentario' => fake()->optional()->sentence(),
        ];
    }

    public function present(): static
    {
        return $this->state(fn (array $attributes) => ['estado' => 'present', 'comentario' => null]);
    }

    public function absent(): static
    {
        return $this->state(fn (array $attributes) => ['estado' => 'absent']);
    }

    public function late(): static
    {
        return $this->state(fn (array $attributes) => ['estado' => 'late']);
    }

    public function justified(): static
    {
        return $this->state(fn (array $attributes) => ['estado' => 'justified']);
    }
}
