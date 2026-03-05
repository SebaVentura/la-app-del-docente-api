<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{
    protected $fillable = [
        'curso_id',
        'clase_id',
        'seccion',
        'tipo',
        'titulo',
        'url',
        'ruta_storage',
    ];

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class);
    }
}
