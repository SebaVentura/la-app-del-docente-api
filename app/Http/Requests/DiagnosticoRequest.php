<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DiagnosticoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'texto' => ['required', 'string'],
            'evidencia' => ['nullable', 'string'],
            'alumno_id' => ['nullable', 'exists:alumnos,id'],
        ];
    }
}
