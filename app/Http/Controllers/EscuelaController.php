<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Escuela;
use App\Http\Requests\EscuelaRequest;

class EscuelaController extends Controller
{
    public function index(Request $request)
    {
        $escuelas = $request->user()->escuelas()->get();
        return response()->json(['data' => $escuelas]);
    }

    public function store(EscuelaRequest $request)
    {
        $escuela = $request->user()->escuelas()->create($request->validated());
        return response()->json(['data' => $escuela], 201);
    }

    public function update(EscuelaRequest $request, Escuela $escuela)
    {
        $this->authorize('update', $escuela);
        $escuela->update($request->validated());
        return response()->json(['data' => $escuela]);
    }

    public function destroy(Escuela $escuela)
    {
        $this->authorize('delete', $escuela);
        $escuela->delete();
        return response()->noContent();
    }
}
