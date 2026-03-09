<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerfilDocente extends Model
{
    use HasFactory;

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
