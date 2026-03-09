<?php

namespace Database\Factories;

use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Diagnostico>
 */
class DiagnosticoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'alumno_id' => null,
            'texto' => fake()->paragraphs(2, true),
            'evidencia' => fake()->optional()->sentence(),
        ];
    }

    public function forAlumno(Alumno $alumno): static
    {
        return $this->state(fn (array $attributes) => [
            'curso_id' => $alumno->curso_id,
            'alumno_id' => $alumno->id,
        ]);
    }

    public function generalCurso(): static
    {
        return $this->state(fn (array $attributes) => [
            'alumno_id' => null,
        ]);
    }
}
