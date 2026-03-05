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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('escuela_id')->constrained('escuelas')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('materia')->nullable();
            $table->string('anio', 20)->nullable();
            $table->string('division', 20)->nullable();
            $table->string('turno', 50)->nullable();
            $table->string('situacion_revista', 100)->nullable();
            $table->string('tipo_carga', 100)->nullable();
            $table->string('cantidad_carga', 50)->nullable();
            $table->json('horarios')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
