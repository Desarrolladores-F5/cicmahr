<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vacaciones', function (Blueprint $table) {
            $table->id();

            // Relación con trabajador
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');

            // Fechas solicitadas
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // Cantidad de días solicitados
            $table->integer('dias_solicitados');

            // Estado de la solicitud
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])->default('pendiente');

            // Comentarios
            $table->text('comentario_trabajador')->nullable();
            $table->text('comentario_admin')->nullable();

            // Fecha en que el admin respondió
            $table->timestamp('fecha_respuesta')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vacaciones');
    }
};
