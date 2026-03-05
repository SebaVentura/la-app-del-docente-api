<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\Curso;
use App\Http\Requests\ClaseRequest;

class ClaseController extends Controller
{
    public function index(Curso $curso, Request $request)
    {
        $this->authorize('view', $curso);
        $clases = $curso->clases()->get();
        return response()->json(['data' => $clases]);
    }

    public function store(Curso $curso, ClaseRequest $request)
    {
        $this->authorize('update', $curso);
        $data = $request->validated();
        $data['curso_id'] = $curso->id;
        $clase = Clase::create($data);
        return response()->json(['data' => $clase], 201);
    }

    public function update(ClaseRequest $request, Clase $clase)
    {
        $this->authorize('update', $clase);
        $clase->update($request->validated());
        return response()->json(['data' => $clase]);
    }

    public function destroy(Clase $clase)
    {
        $this->authorize('delete', $clase);
        $clase->delete();
        return response()->noContent();
    }
}
