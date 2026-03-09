<?php

namespace Database\Factories;

use App\Models\Clase;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Material>
 */
class MaterialFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'clase_id' => null,
            'seccion' => fake()->randomElement(['teoria', 'practica']),
            'tipo' => fake()->randomElement(['link', 'drive', 'pdf']),
            'titulo' => fake()->sentence(4),
            'url' => fake()->url(),
            'ruta_storage' => null,
        ];
    }

    public function teoria(): static
    {
        return $this->state(fn (array $attributes) => ['seccion' => 'teoria']);
    }

    public function practica(): static
    {
        return $this->state(fn (array $attributes) => ['seccion' => 'practica']);
    }

    public function link(): static
    {
        return $this->state(fn (array $attributes) => ['tipo' => 'link']);
    }

    public function drive(): static
    {
        return $this->state(fn (array $attributes) => ['tipo' => 'drive']);
    }

    public function pdf(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 'pdf',
            'ruta_storage' => 'materiales/' . fake()->uuid() . '.pdf',
        ]);
    }

    public function forClase(Clase $clase): static
    {
        return $this->state(fn (array $attributes) => [
            'curso_id' => $clase->curso_id,
            'clase_id' => $clase->id,
        ]);
    }
}
