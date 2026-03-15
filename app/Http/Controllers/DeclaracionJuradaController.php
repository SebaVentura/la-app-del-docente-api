<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeclaracionJuradaRequest;
use App\Models\DeclaracionJurada;
use App\Models\Escuela;
use Illuminate\Http\Request;

class DeclaracionJuradaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = $user->declaracionesJuradas()->newQuery();

        if ($request->filled('escuela_id')) {
            $query->where('escuela_id', $request->input('escuela_id'));
        }

        if ($request->filled('anio_lectivo')) {
            $query->where('anio_lectivo', $request->input('anio_lectivo'));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        $items = $query->get();

        return response()->json(['data' => $items]);
    }

    public function indexByEscuela(Escuela $escuela, Request $request)
    {
        $this->authorize('view', $escuela);

        $query = $escuela->declaracionesJuradas();

        if ($request->filled('anio_lectivo')) {
            $query->where('anio_lectivo', $request->input('anio_lectivo'));
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        $items = $query->get();

        return response()->json(['data' => $items]);
    }

    public function show(DeclaracionJurada $declaracionJurada)
    {
        $this->authorize('view', $declaracionJurada);

        return response()->json(['data' => $declaracionJurada]);
    }

    public function store(Escuela $escuela, DeclaracionJuradaRequest $request)
    {
        $this->authorize('update', $escuela);

        $user = $request->user();
        $data = $request->validated();

        $perfil = $user->perfilDocente;

        $perfilSnapshot = $perfil ? [
            'nombres' => $perfil->nombres,
            'apellidos' => $perfil->apellidos,
            'dni' => $perfil->dni,
            'cuil' => $perfil->cuil,
            'domicilio' => $perfil->domicilio,
            'localidad' => $perfil->localidad,
            'provincia' => $perfil->provincia,
            'telefono' => $perfil->telefono,
        ] : [];

        $escuelaSnapshot = [
            'nombre' => $escuela->nombre,
            'localidad' => $escuela->localidad,
            'provincia' => $escuela->provincia,
        ];

        $declaracion = DeclaracionJurada::create([
            'user_id' => $user->id,
            'escuela_id' => $escuela->id,
            'anio_lectivo' => $data['anio_lectivo'],
            'tipo' => $data['tipo'],
            'estado' => $data['estado'] ?? 'borrador',
            'fecha_generacion' => now(),
            'fecha_firma' => null,
            'perfil_snapshot' => $perfilSnapshot,
            'escuela_snapshot' => $escuelaSnapshot,
            'contenido_generado' => $data['contenido_generado'] ?? null,
            'observaciones' => $data['observaciones'] ?? null,
        ]);

        return response()->json(['data' => $declaracion], 201);
    }

    public function update(DeclaracionJuradaRequest $request, DeclaracionJurada $declaracionJurada)
    {
        $this->authorize('update', $declaracionJurada);

        if ($declaracionJurada->estado !== 'borrador') {
            return response()->json([
                'message' => 'Solo se pueden modificar declaraciones en estado borrador.',
            ], 422);
        }

        $data = $request->validated();

        $declaracionJurada->update([
            'anio_lectivo' => $data['anio_lectivo'],
            'tipo' => $data['tipo'],
            'estado' => $data['estado'] ?? $declaracionJurada->estado,
            'contenido_generado' => $data['contenido_generado'] ?? $declaracionJurada->contenido_generado,
            'observaciones' => $data['observaciones'] ?? $declaracionJurada->observaciones,
        ]);

        return response()->json(['data' => $declaracionJurada]);
    }

    public function destroy(DeclaracionJurada $declaracionJurada)
    {
        $this->authorize('delete', $declaracionJurada);

        if ($declaracionJurada->estado !== 'borrador') {
            return response()->json([
                'message' => 'Solo se pueden eliminar declaraciones en estado borrador.',
            ], 422);
        }

        $declaracionJurada->delete();

        return response()->noContent();
    }
}
