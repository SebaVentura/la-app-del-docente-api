<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trayectorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->cascadeOnDelete();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->string('anio_lectivo', 20);
            $table->text('resumen');
            $table->json('indicadores')->nullable();
            $table->text('observaciones_docente')->nullable();
            $table->string('estado', 50)->default('en_proceso');
            $table->timestamps();

            $table->unique(['alumno_id', 'curso_id', 'anio_lectivo']);
            $table->index('alumno_id');
            $table->index('curso_id');
            $table->index('anio_lectivo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trayectorias');
    }
};
