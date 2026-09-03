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
        Schema::create('honorarios', function (Blueprint $table) {

            $table->id();

            // ======================================================
            // 🏢 EMPRESA PROPIETARIA DEL PRESTADOR
            // ======================================================

            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            // ======================================================
            // 👤 DATOS PERSONALES
            // ======================================================

            $table->string('nombre');
            $table->string('apellido');
            $table->string('rut');
            $table->string('profesion_oficio')->nullable();
            $table->string('direccion')->nullable();
            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();

            // ======================================================
            // 🔐 RUT ÚNICO POR EMPRESA
            // ======================================================

            $table->unique(
                ['empresa_id', 'rut'],
                'honorarios_empresa_rut_unique'
            );

            // ======================================================
            // 🕒 FECHAS DEL REGISTRO
            // ======================================================

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honorarios');
    }
};