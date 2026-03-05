<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Escuela;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Clase;
use App\Models\Asistencia;
use App\Models\Material;
use App\Models\Diagnostico;
use App\Models\Planificacion;

class SyncController extends Controller
{
    public function bootstrap(Request $request)
    {
        $user = $request->user();
        $hasData = $user->escuelas()->exists() || $user->cursos()->exists();

        if ($hasData) {
            return $this->dump($request);
        }

        $payload = $request->all();

        DB::transaction(function () use ($payload, $user) {
            // perfil
            if (! empty($payload['profile'])) {
                $user->perfilDocente()->updateOrCreate(
                    ['user_id' => $user->id],
                    $payload['profile']
                );
            }

            $schoolMap = [];
            if (! empty($payload['schools'])) {
                foreach ($payload['schools'] as $s) {
                    $sch = $user->escuelas()->create([
                        'nombre' => $s['nombre'] ?? '',
                        'localidad' => $s['localidad'] ?? null,
                        'provincia' => $s['provincia'] ?? null,
                    ]);
                    $schoolMap[$s['id']] = $sch->id;
                }
            }

            $courseMap = [];
            if (! empty($payload['courses'])) {
                foreach ($payload['courses'] as $c) {
                    if (! isset($schoolMap[$c['escuelaId']])) {
                        continue;
                    }
                    $curso = Curso::create([
                        'user_id' => $user->id,
                        'escuela_id' => $schoolMap[$c['escuelaId']],
                        'nombre' => $c['nombre'] ?? '',
                        'materia' => $c['materia'] ?? null,
                        'anio' => $c['anio'] ?? null,
                        'division' => $c['division'] ?? null,
                        'turno' => $c['turno'] ?? null,
                        'situacion_revista' => $c['situacion_revista'] ?? null,
                        'tipo_carga' => $c['tipo_carga'] ?? null,
                        'cantidad_carga' => $c['cantidad_carga'] ?? null,
                        'horarios' => $c['horarios'] ?? null,
                    ]);
                    $courseMap[$c['id']] = $curso->id;
                }
            }

            $studentMap = [];
            if (! empty($payload['students'])) {
                foreach ($payload['students'] as $st) {
                    if (! isset($courseMap[$st['cursoId']])) {
                        continue;
                    }
                    $al = Alumno::create([
                        'curso_id' => $courseMap[$st['cursoId']],
                        'apellidos' => $st['apellidos'] ?? '',
                        'nombres' => $st['nombres'] ?? '',
                        'legajo' => $st['legajo'] ?? null,
                    ]);
                    $studentMap[$st['alumnoId'] ?? spl_object_hash($st)] = $al->id;
                    // note: payload may not include unique alumnoId; fallback
                }
            }

            $classMap = [];
            if (! empty($payload['classes'])) {
                foreach ($payload['classes'] as $cl) {
                    if (! isset($courseMap[$cl['cursoId']])) {
                        continue;
                    }
                    $c = Clase::create([
                        'curso_id' => $courseMap[$cl['cursoId']],
                        'fecha' => $cl['fecha'],
                        'titulo' => $cl['titulo'] ?? null,
                    ]);
                    // map by composite key for lookup during attendance import
                    $classMap[$cl['cursoId'] . '|' . $cl['fecha']] = $c->id;
                }
            }

            if (! empty($payload['attendance'])) {
                foreach ($payload['attendance'] as $fecha => $courses) {
                    foreach ($courses as $cursoId => $students) {
                        $key = $cursoId . '|' . $fecha;
                        if (! isset($classMap[$key])) {
                            continue;
                        }
                        foreach ($students as $alumnoId => $att) {
                            Asistencia::updateOrCreate(
                                [
                                    'clase_id' => $classMap[$key],
                                    'alumno_id' => $studentMap[$alumnoId] ?? null,
                                ],
                                ['estado' => $att['estado'] ?? 'present']
                            );
                        }
                    }
                }
            }

            if (! empty($payload['materials'])) {
                foreach ($payload['materials'] as $m) {
                    if (! isset($courseMap[$m['cursoId']])) {
                        continue;
                    }
                    Material::create([
                        'curso_id' => $courseMap[$m['cursoId']],
                        'clase_id' => isset($m['claseId']) && isset($classMap[$m['claseId']]) ? $classMap[$m['claseId']] : null,
                        'seccion' => $m['seccion'] ?? 'teoria',
                        'tipo' => $m['tipo'] ?? 'link',
                        'titulo' => $m['titulo'] ?? null,
                        'url' => $m['url'] ?? null,
                    ]);
                }
            }

            if (! empty($payload['diagnostics'])) {
                foreach ($payload['diagnostics'] as $d) {
                    if (! isset($courseMap[$d['cursoId']])) {
                        continue;
                    }
                    Diagnostico::create([
                        'curso_id' => $courseMap[$d['cursoId']],
                        'alumno_id' => isset($studentMap[$d['alumnoId']]) ? $studentMap[$d['alumnoId']] : null,
                        'texto' => $d['texto'] ?? '',
                        'evidencia' => $d['evidencia'] ?? null,
                    ]);
                }
            }

            if (! empty($payload['plans'])) {
                foreach ($payload['plans'] as $cursoId => $plan) {
                    if (! isset($courseMap[$cursoId])) {
                        continue;
                    }
                    Planificacion::create([
                        'curso_id' => $courseMap[$cursoId],
                        'titulo' => $plan['titulo'] ?? null,
                        'contenido' => $plan['contenido'] ?? null,
                        'fuentes' => $plan['fuentes'] ?? null,
                        'programa_texto' => $plan['programa_texto'] ?? null,
                        'plan' => $plan['plan'] ?? null,
                    ]);
                }
            }
        });

        return response()->json(['ok' => true, 'message' => 'Datos importados']);
    }

    public function dump(Request $request)
    {
        $user = $request->user();
        $data = [];

        $data['profile'] = optional($user->perfilDocente)->toArray();
        $data['schools'] = $user->escuelas()->get()->map(function ($s) {
            return $s->toArray();
        });

        $data['courses'] = $user->cursos()->get()->map(function ($c) {
            return $c->toArray();
        });

        $data['students'] = Alumno::whereIn('curso_id', $user->cursos()->pluck('id'))->get()->map(function ($a) {
            return $a->toArray();
        });

        $data['classes'] = Clase::whereIn('curso_id', $user->cursos()->pluck('id'))->get()->map(function ($c) {
            return $c->toArray();
        });

        // build attendance nested by fecha -> curso_id -> alumno_id
        $attendance = [];
        $asistencias = Asistencia::with('clase')
            ->whereIn('clase_id', Clase::whereIn('curso_id', $user->cursos()->pluck('id'))->pluck('id'))
            ->get();

        foreach ($asistencias as $att) {
            if (! $att->clase) {
                continue;
            }
            $fecha = $att->clase->fecha;
            $cursoId = $att->clase->curso_id;
            $attendance[$fecha][$cursoId][$att->alumno_id] = [
                'estado' => $att->estado,
                'comentario' => $att->comentario,
            ];
        }

        $data['attendance'] = $attendance;

        $data['materials'] = Material::whereIn('curso_id', $user->cursos()->pluck('id'))->get()->map(function ($m) {
            return $m->toArray();
        });

        $data['diagnostics'] = Diagnostico::whereIn('curso_id', $user->cursos()->pluck('id'))->get()->map(function ($d) {
            return $d->toArray();
        });

        $data['plans'] = Planificacion::whereIn('curso_id', $user->cursos()->pluck('id'))->get()->mapWithKeys(function ($p) {
            return [$p->curso_id => $p->toArray()];
        });

        return response()->json(['data' => $data]);
    }
}
