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
        Schema::table('planificaciones', function (Blueprint $table) {
            $table->text('descripcion')->nullable()->after('titulo');
            $table->string('ruta_storage', 500)->nullable()->after('plan');
            $table->string('nombre_original', 255)->nullable()->after('ruta_storage');
            $table->string('mime_type', 100)->nullable()->after('nombre_original');
            $table->unsignedBigInteger('tamano_bytes')->nullable()->after('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('planificaciones', function (Blueprint $table) {
            $table->dropColumn([
                'descripcion',
                'ruta_storage',
                'nombre_original',
                'mime_type',
                'tamano_bytes',
            ]);
        });
    }
};
