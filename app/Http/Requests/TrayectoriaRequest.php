<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TrayectoriaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'anio_lectivo' => ['required', 'string', 'max:20'],
            'resumen' => ['required', 'string'],
            'indicadores' => ['nullable', 'array'],
            'observaciones_docente' => ['nullable', 'string'],
            'estado' => ['nullable', 'string', 'max:50'],
        ];

        $trayectoria = $this->route('trayectoria');

        if ($trayectoria) {
            $rules['anio_lectivo'][] = Rule::unique('trayectorias')
                ->where(function ($query) use ($trayectoria) {
                    return $query
                        ->where('alumno_id', $trayectoria->alumno_id)
                        ->where('curso_id', $trayectoria->curso_id);
                })
                ->ignore($trayectoria->id);
        } else {
            $alumno = $this->route('alumno');

            if ($alumno) {
                $rules['anio_lectivo'][] = Rule::unique('trayectorias')
                    ->where(function ($query) use ($alumno) {
                        return $query
                            ->where('alumno_id', $alumno->id)
                            ->where('curso_id', $alumno->curso_id);
                    });
            }
        }

        return $rules;
    }
}
