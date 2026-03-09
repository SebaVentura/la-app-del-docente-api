<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Trayectoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'anio_lectivo',
        'resumen',
        'indicadores',
        'observaciones_docente',
        'estado',
    ];

    protected function casts(): array
    {
        return [
            'indicadores' => 'array',
        ];
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}
