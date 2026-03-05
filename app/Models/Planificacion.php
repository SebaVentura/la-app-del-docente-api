<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planificacion extends Model
{
    protected $fillable = [
        'curso_id',
        'titulo',
        'contenido',
        'fuentes',
        'programa_texto',
        'plan',
    ];

    protected function casts(): array
    {
        return [
            'plan' => 'array',
        ];
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }
}
