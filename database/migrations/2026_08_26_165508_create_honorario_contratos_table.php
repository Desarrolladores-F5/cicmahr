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
        Schema::create('honorario_contratos', function (Blueprint $table) {

            $table->id();

            // ======================================================
            // 👤 PRESTADOR A HONORARIOS
            // ======================================================

            $table->foreignId('honorario_id')
                ->constrained('honorarios')
                ->cascadeOnDelete();

            // ======================================================
            // 💼 DATOS DEL SERVICIO
            // ======================================================

            $table->string('cargo');
            $table->unsignedBigInteger('monto_honorario');

            // ======================================================
            // 📅 VIGENCIA DEL CONTRATO
            // ======================================================

            $table->date('fecha_inicio');
            $table->date('fecha_termino');

            // ======================================================
            // 🕒 JORNADA
            // ======================================================

            $table->time('hora_inicio')->nullable();
            $table->time('hora_termino')->nullable();
            $table->unsignedSmallInteger('horas_semanales')->nullable();

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
        Schema::dropIfExists('honorario_contratos');
    }
};