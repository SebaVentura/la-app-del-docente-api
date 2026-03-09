<?php

namespace Database\Factories;

use App\Models\Curso;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Planificacion>
 */
class PlanificacionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'curso_id' => Curso::factory(),
            'titulo' => 'Plan ' . fake()->sentence(3),
            'contenido' => fake()->paragraphs(3, true),
            'fuentes' => 'Nucleo de Aprendizajes Prioritarios; Diseno curricular jurisdiccional',
            'programa_texto' => fake()->paragraphs(2, true),
            'plan' => [
                [
                    'unidad' => 'Unidad 1',
                    'objetivos' => ['Reconocer conceptos base', 'Resolver problemas introductorios'],
                    'evaluacion' => 'Cuestionario diagnostico y actividad de cierre',
                ],
                [
                    'unidad' => 'Unidad 2',
                    'objetivos' => ['Aplicar procedimientos en situaciones reales'],
                    'evaluacion' => 'Trabajo practico individual',
                ],
            ],
        ];
    }

    public function withoutPlanJson(): static
    {
        return $this->state(fn (array $attributes) => [
            'plan' => null,
        ]);
    }
}
