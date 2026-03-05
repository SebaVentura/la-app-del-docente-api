<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Planificacion;
use App\Http\Requests\PlanificacionRequest;

class PlanificacionController extends Controller
{
    public function index(Curso $curso, Request $request)
    {
        $this->authorize('view', $curso);
        $plan = $curso->planificacion;
        return response()->json(['data' => $plan]);
    }

    public function store(Curso $curso, PlanificacionRequest $request)
    {
        $this->authorize('update', $curso);
        $data = $request->validated();
        $data['curso_id'] = $curso->id;
        $plan = Planificacion::create($data);
        return response()->json(['data' => $plan], 201);
    }

    public function update(PlanificacionRequest $request, Planificacion $planificacion)
    {
        $this->authorize('update', $planificacion);
        $planificacion->update($request->validated());
        return response()->json(['data' => $planificacion]);
    }
}
