<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfilDocente extends Model
{
    protected $table = 'perfiles_docentes';

    protected $fillable = [
        'user_id',
        'nombres',
        'apellidos',
        'dni',
        'cuil',
        'domicilio',
        'localidad',
        'provincia',
        'telefono',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
