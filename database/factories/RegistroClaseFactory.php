<?php

namespace Database\Factories;

use App\Models\Clase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegistroClase>
 */
class RegistroClaseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'clase_id' => Clase::factory(),
            'contenido' => fake()->paragraphs(2, true),
        ];
    }

    public function emptyContent(): static
    {
        return $this->state(fn (array $attributes) => [
            'contenido' => null,
        ]);
    }
}
