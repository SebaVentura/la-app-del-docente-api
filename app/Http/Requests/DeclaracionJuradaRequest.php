<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeclaracionJuradaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'anio_lectivo' => ['required', 'string', 'max:20'],
            'tipo' => ['required', 'string', 'max:50'],
            'estado' => ['nullable', 'string', 'max:50'],
            'contenido_generado' => ['nullable', 'array'],
            'observaciones' => ['nullable', 'string'],
        ];
    }
}
