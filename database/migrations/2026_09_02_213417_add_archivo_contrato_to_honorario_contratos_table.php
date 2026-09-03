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
        Schema::table('honorario_contratos', function (Blueprint $table) {
            $table->string('nombre_archivo_contrato')
                ->nullable()
                ->after('horas_semanales');

            $table->string('ruta_archivo_contrato')
                ->nullable()
                ->after('nombre_archivo_contrato');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('honorario_contratos', function (Blueprint $table) {
            $table->dropColumn([
                'nombre_archivo_contrato',
                'ruta_archivo_contrato',
            ]);
        });
    }
};