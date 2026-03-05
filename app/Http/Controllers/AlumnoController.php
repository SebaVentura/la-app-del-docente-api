<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Curso;
use App\Http\Requests\AlumnoRequest;

class AlumnoController extends Controller
{
    public function index(Curso $curso, Request $request)
    {
        $this->authorize('view', $curso);
        $alumnos = $curso->alumnos()->get();
        return response()->json(['data' => $alumnos]);
    }

    public function store(Curso $curso, AlumnoRequest $request)
    {
        $this->authorize('update', $curso);
        $alumno = $curso->alumnos()->create($request->validated());
        return response()->json(['data' => $alumno], 201);
    }

    public function update(AlumnoRequest $request, Alumno $alumno)
    {
        $this->authorize('update', $alumno);
        $alumno->update($request->validated());
        return response()->json(['data' => $alumno]);
    }

    public function destroy(Alumno $alumno)
    {
        $this->authorize('delete', $alumno);
        $alumno->delete();
        return response()->noContent();
    }
}
