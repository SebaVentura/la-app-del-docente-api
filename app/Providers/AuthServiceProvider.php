<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

use App\Models\Escuela;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Clase;
use App\Models\Material;
use App\Models\Diagnostico;
use App\Models\Planificacion;
use App\Models\Trayectoria;
use App\Models\DeclaracionJurada;

use App\Policies\EscuelaPolicy;
use App\Policies\CursoPolicy;
use App\Policies\AlumnoPolicy;
use App\Policies\ClasePolicy;
use App\Policies\MaterialPolicy;
use App\Policies\DiagnosticoPolicy;
use App\Policies\PlanificacionPolicy;
use App\Policies\TrayectoriaPolicy;
use App\Policies\DeclaracionJuradaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Escuela::class => EscuelaPolicy::class,
        Curso::class => CursoPolicy::class,
        Alumno::class => AlumnoPolicy::class,
        Clase::class => ClasePolicy::class,
        Material::class => MaterialPolicy::class,
        Diagnostico::class => DiagnosticoPolicy::class,
        Planificacion::class => PlanificacionPolicy::class,
        Trayectoria::class => TrayectoriaPolicy::class,
        DeclaracionJurada::class => DeclaracionJuradaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
