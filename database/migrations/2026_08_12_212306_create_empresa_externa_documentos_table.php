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
        Schema::create('empresa_externa_documentos', function (Blueprint $table) {

            $table->id();

            // ======================================================
            // 🏢 EMPRESA EXTERNA
            // ======================================================

            $table->foreignId('empresa_externa_id')
                ->constrained('empresa_externas')
                ->cascadeOnDelete();

            // ======================================================
            // 📄 INFORMACIÓN DEL DOCUMENTO
            // ======================================================

            $table->string('nombre_documento');

            $table->string('tipo_documento');

            $table->string('archivo');

            // ======================================================
            // 📅 VIGENCIA
            // ======================================================

            $table->date('fecha_emision')->nullable();

            $table->date('fecha_vencimiento')->nullable();

            // ======================================================
            // 📝 INFORMACIÓN ADICIONAL
            // ======================================================

            $table->text('observaciones')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa_externa_documentos');
    }
};
