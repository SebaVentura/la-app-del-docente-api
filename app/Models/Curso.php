<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Curso extends Model
{
    protected $fillable = [
        'user_id',
        'escuela_id',
        'nombre',
        'materia',
        'anio',
        'division',
        'turno',
        'situacion_revista',
        'tipo_carga',
        'cantidad_carga',
        'horarios',
    ];

    protected function casts(): array
    {
        return [
            'horarios' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function escuela(): BelongsTo
    {
        return $this->belongsTo(Escuela::class);
    }

    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class, 'curso_id');
    }

    public function clases(): HasMany
    {
        return $this->hasMany(Clase::class, 'curso_id');
    }

    public function materiales(): HasMany
    {
        return $this->hasMany(Material::class, 'curso_id');
    }

    public function diagnosticos(): HasMany
    {
        return $this->hasMany(Diagnostico::class, 'curso_id');
    }

    public function planificacion(): HasOne
    {
        return $this->hasOne(Planificacion::class, 'curso_id');
    }
}
