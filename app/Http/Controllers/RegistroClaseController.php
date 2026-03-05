<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;
use App\Models\RegistroClase;
use App\Http\Requests\RegistroClaseRequest;

class RegistroClaseController extends Controller
{
    public function show(Clase $clase)
    {
        $this->authorize('view', $clase);
        $registro = $clase->registros()->latest()->first();
        return response()->json(['data' => $registro]);
    }

    public function store(RegistroClaseRequest $request, Clase $clase)
    {
        $this->authorize('update', $clase);
        $data = $request->validated();
        $record = $clase->registros()->create($data);
        return response()->json(['data' => $record], 201);
    }
}
