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
        Schema::create('horas_extras', function (Blueprint $table) {
            $table->id();

            $table->foreignId('trabajador_id')
                ->constrained('trabajadores')
                ->cascadeOnDelete();

            $table->date('fecha');

            $table->decimal('horas', 4, 2);

            $table->string('motivo')->nullable();

            $table->enum('estado', ['aprobado', 'rechazado'])->default('aprobado');

            $table->foreignId('registrado_por')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas_extras');
    }
};
