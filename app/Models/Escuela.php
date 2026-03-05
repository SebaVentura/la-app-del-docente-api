<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Escuela extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'localidad',
        'provincia',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'escuela_id');
    }
}
