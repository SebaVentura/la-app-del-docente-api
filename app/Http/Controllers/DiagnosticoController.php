<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumno;
use App\Models\Diagnostico;
use App\Http\Requests\DiagnosticoRequest;

class DiagnosticoController extends Controller
{
    public function index(Alumno $alumno, Request $request)
    {
        $this->authorize('view', $alumno);
        $diagnosticos = $alumno->diagnosticos()->get();
        return response()->json(['data' => $diagnosticos]);
    }

    public function store(Alumno $alumno, DiagnosticoRequest $request)
    {
        $this->authorize('update', $alumno);
        $data = $request->validated();
        $data['curso_id'] = $alumno->curso_id;
        $data['alumno_id'] = $alumno->id;
        $diag = Diagnostico::create($data);
        return response()->json(['data' => $diag], 201);
    }
}
