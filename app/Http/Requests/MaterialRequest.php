<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'seccion' => ['required', 'in:teoria,practica'],
            'tipo' => ['required', 'in:link,drive,pdf'],
            'titulo' => ['nullable', 'string', 'max:255'],
            'url' => ['nullable', 'string'],
        ];
    }
}
