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
        Schema::create('trabajadores', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();

            $table->string('rut', 20);
            $table->string('nombre', 150);
            $table->string('apellido', 150);
            $table->string('cargo', 150)->nullable();
            $table->decimal('sueldo', 12, 2)->nullable();
            $table->enum('tipo_contrato', ['plazo_fijo', 'indefinido'])->nullable();
            $table->date('fecha_ingreso')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->enum('estado', ['vigente', 'no_vigente'])->default('vigente');
            $table->string('horario', 150)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();

            $table->timestamps();

            $table->unique(['empresa_id', 'rut']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trabajadores');
    }
};
