<?php

namespace Database\Factories;

use App\Models\Trayectoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Trayectoria>
 */
class TrayectoriaFactory extends Factory
{
    protected $model = Trayectoria::class;

    public function definition(): array
    {
        return [
            'anio_lectivo' => (string) $this->faker->year(),
            'resumen' => $this->faker->paragraph(),
            'indicadores' => [
                'asistencia' => $this->faker->randomFloat(2, 0.5, 1.0),
                'diagnosticos' => $this->faker->numberBetween(0, 5),
            ],
            'observaciones_docente' => $this->faker->boolean(40) ? $this->faker->sentence() : null,
            'estado' => $this->faker->randomElement(['en_proceso', 'cerrada']),
        ];
    }
}
