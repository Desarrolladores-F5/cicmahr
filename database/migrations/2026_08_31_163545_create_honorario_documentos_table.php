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
        Schema::create('honorario_documentos', function (Blueprint $table) {

            $table->id();

            // ======================================================
            // 👤 PRESTADOR A HONORARIOS
            // ======================================================

            $table->foreignId('honorario_id')
                ->constrained('honorarios')
                ->cascadeOnDelete();

            // ======================================================
            // 📄 INFORMACIÓN DEL DOCUMENTO
            // ======================================================

            $table->string('tipo', 100);

            $table->string('nombre_original');

            $table->string('ruta_archivo');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('honorario_documentos');
    }
};