<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Perfil
    Route::get('/perfil', [\App\Http\Controllers\PerfilController::class, 'show']);
    Route::put('/perfil', [\App\Http\Controllers\PerfilController::class, 'update']);

    // Escuelas
    Route::get('/escuelas', [\App\Http\Controllers\EscuelaController::class, 'index']);
    Route::post('/escuelas', [\App\Http\Controllers\EscuelaController::class, 'store']);
    Route::put('/escuelas/{escuela}', [\App\Http\Controllers\EscuelaController::class, 'update']);
    Route::delete('/escuelas/{escuela}', [\App\Http\Controllers\EscuelaController::class, 'destroy']);

    // Cursos
    Route::get('/escuelas/{escuela}/cursos', [\App\Http\Controllers\CursoController::class, 'index']);
    Route::post('/escuelas/{escuela}/cursos', [\App\Http\Controllers\CursoController::class, 'store']);
    Route::put('/cursos/{curso}', [\App\Http\Controllers\CursoController::class, 'update']);
    Route::delete('/cursos/{curso}', [\App\Http\Controllers\CursoController::class, 'destroy']);

    // Alumnos
    Route::get('/cursos/{curso}/alumnos', [\App\Http\Controllers\AlumnoController::class, 'index']);
    Route::post('/cursos/{curso}/alumnos', [\App\Http\Controllers\AlumnoController::class, 'store']);
    Route::put('/alumnos/{alumno}', [\App\Http\Controllers\AlumnoController::class, 'update']);
    Route::delete('/alumnos/{alumno}', [\App\Http\Controllers\AlumnoController::class, 'destroy']);

    // Clases
    Route::get('/cursos/{curso}/clases', [\App\Http\Controllers\ClaseController::class, 'index']);
    Route::post('/cursos/{curso}/clases', [\App\Http\Controllers\ClaseController::class, 'store']);
    Route::put('/clases/{clase}', [\App\Http\Controllers\ClaseController::class, 'update']);
    Route::delete('/clases/{clase}', [\App\Http\Controllers\ClaseController::class, 'destroy']);

    // Asistencias
    Route::post('/clases/{clase}/asistencias', [\App\Http\Controllers\AsistenciaController::class, 'store']);
    Route::get('/clases/{clase}/asistencias', [\App\Http\Controllers\AsistenciaController::class, 'index']);

    // Registro de clase
    Route::get('/clases/{clase}/registro', [\App\Http\Controllers\RegistroClaseController::class, 'show']);
    Route::post('/clases/{clase}/registro', [\App\Http\Controllers\RegistroClaseController::class, 'store']);

    // Materiales
    Route::get('/cursos/{curso}/materiales', [\App\Http\Controllers\MaterialController::class, 'index']);
    Route::post('/cursos/{curso}/materiales', [\App\Http\Controllers\MaterialController::class, 'store']);
    Route::put('/materiales/{material}', [\App\Http\Controllers\MaterialController::class, 'update']);
    Route::delete('/materiales/{material}', [\App\Http\Controllers\MaterialController::class, 'destroy']);

    // Diagnosticos
    Route::get('/alumnos/{alumno}/diagnosticos', [\App\Http\Controllers\DiagnosticoController::class, 'index']);
    Route::post('/alumnos/{alumno}/diagnosticos', [\App\Http\Controllers\DiagnosticoController::class, 'store']);

    // Planificaciones
    Route::get('/cursos/{curso}/planificaciones', [\App\Http\Controllers\PlanificacionController::class, 'index']);
    Route::post('/cursos/{curso}/planificaciones', [\App\Http\Controllers\PlanificacionController::class, 'store']);
    Route::put('/planificaciones/{planificacion}', [\App\Http\Controllers\PlanificacionController::class, 'update']);

    // Sync
    Route::post('/sync/bootstrap', [\App\Http\Controllers\SyncController::class, 'bootstrap']);
    Route::get('/sync/dump', [\App\Http\Controllers\SyncController::class, 'dump']);
});
