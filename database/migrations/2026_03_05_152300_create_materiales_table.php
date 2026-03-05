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
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
            $table->foreignId('clase_id')->nullable()->constrained('clases')->nullOnDelete();
            $table->enum('seccion', ['teoria', 'practica']);
            $table->enum('tipo', ['link', 'drive', 'pdf']);
            $table->string('titulo')->nullable();
            $table->text('url')->nullable();
            $table->string('ruta_storage', 500)->nullable();
            $table->timestamps();

            $table->index('curso_id');
            $table->index('clase_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materiales');
    }
};
