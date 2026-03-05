<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'materia' => ['nullable', 'string', 'max:255'],
            'anio' => ['nullable', 'string', 'max:20'],
            'division' => ['nullable', 'string', 'max:20'],
            'turno' => ['nullable', 'string', 'max:50'],
            'situacion_revista' => ['nullable', 'string', 'max:100'],
            'tipo_carga' => ['nullable', 'string', 'max:100'], // consider validating list in business logic
            'cantidad_carga' => ['nullable', 'string', 'max:50', 'regex:/^\d+(\.\d+)?$/'],
            'horarios' => ['nullable', 'array'],
            'horarios.*.dia' => ['required_with:horarios', 'string'],
            'horarios.*.desde' => ['required_with:horarios', 'string'],
            'horarios.*.hasta' => ['required_with:horarios', 'string'],
        ];
    }
}
