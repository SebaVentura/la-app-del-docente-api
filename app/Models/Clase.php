<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Clase extends Model
{
    protected $fillable = [
        'curso_id',
        'fecha',
        'titulo',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function asistencias(): HasMany
    {
        return $this->hasMany(Asistencia::class, 'clase_id');
    }

    public function registros(): HasMany
    {
        return $this->hasMany(RegistroClase::class, 'clase_id');
    }

    public function materiales(): HasMany
    {
        return $this->hasMany(Material::class, 'clase_id');
    }
}
