<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\Clase;
use App\Models\Curso;
use App\Models\Diagnostico;
use App\Models\Escuela;
use App\Models\Material;
use App\Models\Planificacion;
use App\Models\RegistroClase;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AcademicDomainSeeder extends Seeder
{
    private const ATTENDANCE_STATES = ['present', 'absent', 'late', 'justified'];

    public function run(): void
    {
        $admin = User::where('email', 'admin@test.com')->first();
        $teacher = User::where('email', 'teacher@test.com')->first();
        $assistant = User::where('email', 'colega@test.com')->first();

        if (! $admin || ! $teacher || ! $assistant) {
            return;
        }

        $this->resetUserDomain($admin);
        $this->resetUserDomain($teacher);
        $this->resetUserDomain($assistant);

        $this->seedAdminDomain($admin);
        $this->seedTeacherDomain($teacher);
        $this->seedAssistantDomain($assistant);
    }

    private function seedAdminDomain(User $user): void
    {
        $escuelaCentro = Escuela::factory()->create([
            'user_id' => $user->id,
            'nombre' => 'Escuela Secundaria N 12 - Centro',
            'localidad' => 'La Plata',
            'provincia' => 'Buenos Aires',
        ]);

        $escuelaTecnica = Escuela::factory()->create([
            'user_id' => $user->id,
            'nombre' => 'Escuela Tecnica N 4',
            'localidad' => 'Berisso',
            'provincia' => 'Buenos Aires',
        ]);

        Escuela::factory()->withoutLocation()->create([
            'user_id' => $user->id,
            'nombre' => 'Escuela Rural Itinerante',
        ]);

        $this->seedCourseScenario($user, $escuelaCentro, [
            'nombre' => '1A - Matematica',
            'materia' => 'Matematica',
            'anio' => '1',
            'division' => 'A',
            'turno' => 'Manana',
            'student_count' => 22,
            'class_count' => 6,
            'with_plan' => true,
            'with_course_materials' => true,
            'with_diagnostics' => true,
        ]);

        $this->seedCourseScenario($user, $escuelaCentro, [
            'nombre' => '2B - Fisica',
            'materia' => 'Fisica',
            'anio' => '2',
            'division' => 'B',
            'turno' => 'Tarde',
            'student_count' => 18,
            'class_count' => 5,
            'with_plan' => true,
            'with_course_materials' => true,
            'with_diagnostics' => true,
        ]);

        $this->seedCourseScenario($user, $escuelaCentro, [
            'nombre' => '3A - Historia',
            'materia' => 'Historia',
            'anio' => '3',
            'division' => 'A',
            'turno' => 'Noche',
            'student_count' => 0,
            'class_count' => 3,
            'with_plan' => false,
            'with_course_materials' => true,
            'with_diagnostics' => false,
        ]);

        $this->seedCourseScenario($user, $escuelaTecnica, [
            'nombre' => '4A - Programacion',
            'materia' => 'Tecnologia',
            'anio' => '4',
            'division' => 'A',
            'turno' => 'Tarde',
            'student_count' => 15,
            'class_count' => 4,
            'with_plan' => true,
            'with_course_materials' => true,
            'with_diagnostics' => true,
        ]);

        $this->seedCourseScenario($user, $escuelaTecnica, [
            'nombre' => '5A - Taller Integrador',
            'materia' => 'Tecnologia',
            'anio' => '5',
            'division' => 'A',
            'turno' => 'Manana',
            'student_count' => 12,
            'class_count' => 0,
            'with_plan' => true,
            'with_course_materials' => true,
            'with_diagnostics' => true,
        ]);

        $this->seedCourseScenario($user, $escuelaTecnica, [
            'nombre' => '6B - Proyecto Final',
            'materia' => 'Programacion',
            'anio' => '6',
            'division' => 'B',
            'turno' => 'Noche',
            'student_count' => 10,
            'class_count' => 2,
            'with_plan' => false,
            'with_course_materials' => false,
            'with_diagnostics' => true,
        ]);
    }

    private function seedTeacherDomain(User $user): void
    {
        $escuela = Escuela::factory()->create([
            'user_id' => $user->id,
            'nombre' => 'Colegio Provincial del Mar',
            'localidad' => 'Mar del Plata',
            'provincia' => 'Buenos Aires',
        ]);

        $this->seedCourseScenario($user, $escuela, [
            'nombre' => '1C - Lengua',
            'materia' => 'Lengua',
            'anio' => '1',
            'division' => 'C',
            'turno' => 'Manana',
            'student_count' => 16,
            'class_count' => 3,
            'with_plan' => true,
            'with_course_materials' => true,
            'with_diagnostics' => true,
        ]);

        $this->seedCourseScenario($user, $escuela, [
            'nombre' => '2C - Lengua y Literatura',
            'materia' => 'Lengua',
            'anio' => '2',
            'division' => 'C',
            'turno' => 'Tarde',
            'student_count' => 14,
            'class_count' => 2,
            'with_plan' => false,
            'with_course_materials' => true,
            'with_diagnostics' => false,
        ]);
    }

    private function seedAssistantDomain(User $user): void
    {
        $escuela = Escuela::factory()->create([
            'user_id' => $user->id,
            'nombre' => 'Escuela Secundaria N 25',
            'localidad' => 'Rosario',
            'provincia' => 'Santa Fe',
        ]);

        $this->seedCourseScenario($user, $escuela, [
            'nombre' => '3B - Ciencias Sociales',
            'materia' => 'Historia',
            'anio' => '3',
            'division' => 'B',
            'turno' => 'Tarde',
            'student_count' => 8,
            'class_count' => 1,
            'with_plan' => true,
            'with_course_materials' => false,
            'with_diagnostics' => true,
        ]);
    }

    private function seedCourseScenario(User $user, Escuela $escuela, array $config): void
    {
        $horarios = [
            [
                'dia' => 'Lunes',
                'desde' => '08:00',
                'hasta' => '09:20',
            ],
            [
                'dia' => 'Miercoles',
                'desde' => '10:00',
                'hasta' => '11:20',
            ],
        ];

        $curso = Curso::factory()->create([
            'user_id' => $user->id,
            'escuela_id' => $escuela->id,
            'nombre' => $config['nombre'],
            'materia' => $config['materia'],
            'anio' => $config['anio'],
            'division' => $config['division'],
            'turno' => $config['turno'],
            'situacion_revista' => 'Titular',
            'tipo_carga' => 'Catedra',
            'cantidad_carga' => '3',
            'horarios' => $horarios,
        ]);

        $alumnos = collect();
        for ($i = 1; $i <= $config['student_count']; $i++) {
            $alumnos->push(Alumno::factory()->create([
                'curso_id' => $curso->id,
                'legajo' => $i % 5 === 0 ? null : sprintf('%d%03d', $curso->id, $i),
            ]));
        }

        $clases = collect();
        $baseDate = Carbon::now()->subWeeks(6);
        for ($i = 0; $i < $config['class_count']; $i++) {
            $clases->push(Clase::factory()->create([
                'curso_id' => $curso->id,
                'fecha' => $baseDate->copy()->addDays($i * 7)->toDateString(),
                'titulo' => sprintf('Clase %d - %s', $i + 1, $curso->materia),
            ]));
        }

        foreach ($clases as $classIndex => $clase) {
            if ($alumnos->isNotEmpty()) {
                foreach ($alumnos as $studentIndex => $alumno) {
                    $estado = self::ATTENDANCE_STATES[($classIndex + $studentIndex) % count(self::ATTENDANCE_STATES)];
                    Asistencia::factory()->create([
                        'clase_id' => $clase->id,
                        'alumno_id' => $alumno->id,
                        'estado' => $estado,
                        'comentario' => $estado === 'present' ? null : 'Seguimiento ' . $estado,
                    ]);
                }
            }

            if ($classIndex === 0) {
                RegistroClase::factory()->create([
                    'clase_id' => $clase->id,
                    'contenido' => 'Inicio de unidad y acuerdos de trabajo.',
                ]);
            }

            if ($classIndex === 1) {
                RegistroClase::factory()->create([
                    'clase_id' => $clase->id,
                    'contenido' => 'Desarrollo de contenidos y actividad grupal.',
                ]);
                RegistroClase::factory()->create([
                    'clase_id' => $clase->id,
                    'contenido' => 'Cierre de clase con consignas para el hogar.',
                ]);
            }
        }

        if ($config['with_course_materials']) {
            Material::factory()->teoria()->link()->create([
                'curso_id' => $curso->id,
                'clase_id' => null,
                'titulo' => 'Marco teorico inicial',
                'url' => 'https://example.edu/marco-teorico-' . $curso->id,
            ]);

            Material::factory()->practica()->pdf()->create([
                'curso_id' => $curso->id,
                'clase_id' => null,
                'titulo' => 'Guia de actividades',
                'url' => null,
            ]);
        }

        if ($clases->isNotEmpty()) {
            Material::factory()->drive()->forClase($clases->first())->create([
                'titulo' => 'Presentacion de la primera clase',
                'url' => 'https://drive.google.com/file/d/' . $curso->id,
            ]);
        }

        if ($config['with_diagnostics']) {
            Diagnostico::factory()->generalCurso()->create([
                'curso_id' => $curso->id,
                'texto' => 'Diagnostico general del grupo y acuerdos pedagogicos.',
                'evidencia' => null,
            ]);

            foreach ($alumnos->take(2) as $alumno) {
                Diagnostico::factory()->forAlumno($alumno)->create([
                    'texto' => 'Seguimiento individual de trayectoria escolar.',
                    'evidencia' => 'Se observa avance sostenido en actividades de clase.',
                ]);
            }
        }

        if ($config['with_plan']) {
            Planificacion::factory()->create([
                'curso_id' => $curso->id,
                'titulo' => 'Planificacion anual de ' . $curso->materia,
            ]);
        }
    }

    private function resetUserDomain(User $user): void
    {
        // Deleting schools cascades courses and all dependent records.
        $user->escuelas()->delete();

        // Defensive cleanup in case any course exists outside the school relation.
        $user->cursos()->delete();
    }
}
