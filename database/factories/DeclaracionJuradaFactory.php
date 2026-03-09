<?php

namespace Database\Factories;

use App\Models\DeclaracionJurada;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DeclaracionJurada>
 */
class DeclaracionJuradaFactory extends Factory
{
    protected $model = DeclaracionJurada::class;

    public function definition(): array
    {
        $anio = (string) $this->faker->year();

        return [
            'anio_lectivo' => $anio,
            'tipo' => $this->faker->randomElement(['carga_horaria', 'asistencia', 'planificacion']),
            'estado' => $this->faker->randomElement(['borrador', 'enviada', 'aprobada']),
            'fecha_generacion' => $this->faker->dateTimeBetween("$anio-02-01", "$anio-12-15"),
            'fecha_firma' => $this->faker->boolean(50) ? $this->faker->dateTimeBetween("$anio-03-01", "$anio-12-20") : null,
            'perfil_snapshot' => [
                'nombres' => $this->faker->firstName(),
                'apellidos' => $this->faker->lastName(),
                'dni' => $this->faker->optional()->numerify('########'),
            ],
            'escuela_snapshot' => [
                'nombre' => $this->faker->company(),
                'localidad' => $this->faker->city(),
                'provincia' => $this->faker->state(),
            ],
            'contenido_generado' => [
                'texto' => $this->faker->paragraph(),
            ],
            'observaciones' => $this->faker->boolean(30) ? $this->faker->sentence() : null,
        ];
    }
}
