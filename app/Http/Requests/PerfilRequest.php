<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // authorization handled elsewhere
    }

    public function rules(): array
    {
        return [
            'nombres' => ['nullable', 'string', 'max:255'],
            'apellidos' => ['nullable', 'string', 'max:255'],
            'dni' => ['nullable', 'string', 'max:20'],
            'cuil' => ['nullable', 'string', 'max:20'],
            'domicilio' => ['nullable', 'string'],
            'localidad' => ['nullable', 'string', 'max:255'],
            'provincia' => ['nullable', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:50'],
        ];
    }
}
