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
        Schema::create('declaraciones_juradas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('escuela_id')->constrained('escuelas')->cascadeOnDelete();
            $table->string('anio_lectivo', 20);
            $table->string('tipo', 50);
            $table->string('estado', 50)->default('borrador');
            $table->timestamp('fecha_generacion');
            $table->timestamp('fecha_firma')->nullable();
            $table->json('perfil_snapshot');
            $table->json('escuela_snapshot');
            $table->json('contenido_generado')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('escuela_id');
            $table->index('anio_lectivo');
            $table->index('tipo');
            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('declaraciones_juradas');
    }
};
