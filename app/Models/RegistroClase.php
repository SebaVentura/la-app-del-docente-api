<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistroClase extends Model
{
    protected $table = 'registros_clase';

    protected $fillable = [
        'clase_id',
        'contenido',
    ];

    public function clase(): BelongsTo
    {
        return $this->belongsTo(Clase::class);
    }
}
