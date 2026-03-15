<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TrayectoriaRequest;
use App\Models\Alumno;
use App\Models\Curso;
use App\Models\Trayectoria;

class TrayectoriaController extends Controller
{
    public function indexByCurso(Curso $curso, Request $request)
    {
        $this->authorize('view', $curso);

        $trayectorias = $curso->trayectorias()->get();

        return response()->json(['data' => $trayectorias]);
    }

    public function indexByAlumno(Alumno $alumno, Request $request)
    {
        $this->authorize('view', $alumno);

        $trayectorias = $alumno->trayectorias()->get();

        return response()->json(['data' => $trayectorias]);
    }

    public function show(Trayectoria $trayectoria)
    {
        $this->authorize('view', $trayectoria);

        return response()->json(['data' => $trayectoria]);
    }

    public function store(Alumno $alumno, TrayectoriaRequest $request)
    {
        $this->authorize('update', $alumno);

        $data = $request->validated();
        $data['alumno_id'] = $alumno->id;
        $data['curso_id'] = $alumno->curso_id;

        if (! isset($data['estado'])) {
            $data['estado'] = 'en_proceso';
        }

        $trayectoria = Trayectoria::create($data);

        return response()->json(['data' => $trayectoria], 201);
    }

    public function update(TrayectoriaRequest $request, Trayectoria $trayectoria)
    {
        $this->authorize('update', $trayectoria);

        $trayectoria->update($request->validated());

        return response()->json(['data' => $trayectoria]);
    }

    public function destroy(Trayectoria $trayectoria)
    {
        $this->authorize('delete', $trayectoria);

        $trayectoria->delete();

        return response()->noContent();
    }
}
