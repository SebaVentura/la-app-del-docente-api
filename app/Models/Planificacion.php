<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Planificacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'curso_id',
        'titulo',
        'descripcion',
        'contenido',
        'fuentes',
        'programa_texto',
        'plan',
        'ruta_storage',
        'nombre_original',
        'mime_type',
        'tamano_bytes',
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
