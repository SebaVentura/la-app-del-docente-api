<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clase;

class AsistenciaController extends Controller
{
    public function index(Clase $clase)
    {
        $this->authorize('view', $clase);
        return response()->json(['data' => $clase->asistencias()->get()]);
    }

    public function store(Request $request, Clase $clase)
    {
        $this->authorize('update', $clase);

        $data = $request->validate([
            'asistencias' => ['required', 'array'],
            'asistencias.*.alumno_id' => ['required', 'exists:alumnos,id'],
            'asistencias.*.estado' => ['required', 'in:present,absent,late,justified'],
            'asistencias.*.comentario' => ['nullable', 'string'],
        ]);

        $result = [];
        foreach ($data['asistencias'] as $item) {
            $record = $clase->asistencias()->updateOrCreate(
                ['alumno_id' => $item['alumno_id']],
                ['estado' => $item['estado'], 'comentario' => $item['comentario'] ?? null]
            );
            $result[] = $record;
        }

        return response()->json(['data' => $result]);
    }
}
