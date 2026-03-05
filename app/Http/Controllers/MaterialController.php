<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Material;
use App\Http\Requests\MaterialRequest;

class MaterialController extends Controller
{
    public function index(Curso $curso, Request $request)
    {
        $this->authorize('view', $curso);
        $materials = $curso->materiales()->get();
        return response()->json(['data' => $materials]);
    }

    public function store(Curso $curso, MaterialRequest $request)
    {
        $this->authorize('update', $curso);
        $data = $request->validated();
        $data['curso_id'] = $curso->id;
        $material = Material::create($data);
        return response()->json(['data' => $material], 201);
    }

    public function update(MaterialRequest $request, Material $material)
    {
        $this->authorize('update', $material);
        $material->update($request->validated());
        return response()->json(['data' => $material]);
    }

    public function destroy(Material $material)
    {
        $this->authorize('delete', $material);
        $material->delete();
        return response()->noContent();
    }
}
