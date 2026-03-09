<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeclaracionJurada extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'escuela_id',
        'anio_lectivo',
        'tipo',
        'estado',
        'fecha_generacion',
        'fecha_firma',
        'perfil_snapshot',
        'escuela_snapshot',
        'contenido_generado',
        'observaciones',
    ];

    protected function casts(): array
    {
        return [
            'fecha_generacion' => 'datetime',
            'fecha_firma' => 'datetime',
            'perfil_snapshot' => 'array',
            'escuela_snapshot' => 'array',
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
}
