<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanificacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['nullable', 'string', 'max:255'],
            'contenido' => ['nullable', 'string'],
            'fuentes' => ['nullable', 'string'],
            'programa_texto' => ['nullable', 'string'],
            'plan' => ['nullable', 'array'],
        ];
    }
}
