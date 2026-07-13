<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*** Run the migrations.*/

    public function up(): void
    {
        Schema::create('empresa_externas', function (Blueprint $table) {

            $table->id();

            // ======================================================
            // 🏢 EMPRESA CLIENTE (MULTIEMPRESA)
            // ======================================================

            $table->foreignId('empresa_id')
                ->constrained()
                ->cascadeOnDelete();

            // ======================================================
            // 🏢 DATOS DE LA EMPRESA EXTERNA
            // ======================================================

            $table->string('razon_social');

            $table->string('rut_empresa');

            $table->string('nombre_fantasia')->nullable();

            $table->string('actividad');

            // ======================================================
            // 👤 REPRESENTANTE LEGAL
            // ======================================================

            $table->string('nombre_representante');

            $table->string('rut_representante');

            $table->string('profesion_representante')->nullable();

            $table->string('estado_civil_representante')->nullable();

            // ======================================================
            // 📍 CONTACTO
            // ======================================================

            $table->string('correo_empresa')->nullable();

            $table->string('telefono_empresa')->nullable();

            $table->string('correo_representante')->nullable();

            $table->string('telefono_representante')->nullable();

            $table->string('direccion')->nullable();

            $table->string('ciudad')->nullable();

            // ======================================================
            // ⚙️ ESTADO
            // ======================================================

            $table->enum('estado', [
                'activo',
                'finalizado',
                'suspendido',
            ])->default('activo');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_externas');
    }
};
