<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Trayectoria;
use Illuminate\Database\Seeder;

class TrayectoriaSeeder extends Seeder
{
    public function run(): void
    {
        $alumnos = Alumno::with('curso')->get();

        foreach ($alumnos as $alumno) {
            if (! $alumno->curso) {
                continue;
            }

            Trayectoria::factory()->create([
                'alumno_id' => $alumno->id,
                'curso_id' => $alumno->curso_id,
                'anio_lectivo' => now()->year,
            ]);
        }
    }
}
