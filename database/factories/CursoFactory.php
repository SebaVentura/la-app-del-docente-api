<?php

namespace Database\Factories;

use App\Models\Escuela;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'escuela_id' => Escuela::factory(),
            'nombre' => fake()->randomElement(['1A', '1B', '2A', '2B', '3A', '3B']) . ' - ' . fake()->randomElement(['Matematica', 'Lengua', 'Historia', 'Fisica']),
            'materia' => fake()->randomElement(['Matematica', 'Lengua', 'Historia', 'Fisica', 'Quimica', 'Tecnologia']),
            'anio' => (string) fake()->numberBetween(1, 6),
            'division' => fake()->randomElement(['A', 'B', 'C']),
            'turno' => fake()->randomElement(['Manana', 'Tarde', 'Noche']),
            'situacion_revista' => fake()->randomElement(['Titular', 'Suplente', 'Interino']),
            'tipo_carga' => fake()->randomElement(['Modular', 'Catedra']),
            'cantidad_carga' => (string) fake()->randomElement([2, 3, 4, 6]),
            'horarios' => [
                [
                    'dia' => fake()->randomElement(['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes']),
                    'desde' => fake()->randomElement(['07:30', '08:00', '09:00', '13:30']),
                    'hasta' => fake()->randomElement(['08:30', '09:20', '10:00', '14:30']),
                ],
            ],
        ];
    }

    public function withoutSchedule(): static
    {
        return $this->state(fn (array $attributes) => [
            'horarios' => null,
        ]);
    }
}
