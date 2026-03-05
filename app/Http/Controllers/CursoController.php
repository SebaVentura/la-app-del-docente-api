<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Escuela;
use App\Http\Requests\CursoRequest;

class CursoController extends Controller
{
    public function index(Escuela $escuela, Request $request)
    {
        $this->authorize('view', $escuela);
        $cursos = $escuela->cursos()->get();
        return response()->json(['data' => $cursos]);
    }

    public function store(Escuela $escuela, CursoRequest $request)
    {
        $this->authorize('update', $escuela);
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;
        $curso = $escuela->cursos()->create($data);
        return response()->json(['data' => $curso], 201);
    }

    public function update(CursoRequest $request, Curso $curso)
    {
        $this->authorize('update', $curso);
        $curso->update($request->validated());
        return response()->json(['data' => $curso]);
    }

    public function destroy(Curso $curso)
    {
        $this->authorize('delete', $curso);
        $curso->delete();
        return response()->noContent();
    }
}
