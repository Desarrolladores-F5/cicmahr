<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reglamento_entregas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reglamento_id')->constrained()->onDelete('cascade');
            $table->foreignId('trabajador_id')->constrained('trabajadores')->onDelete('cascade');
            $table->boolean('leido')->default(false);
            $table->timestamp('fecha_lectura')->nullable();

            $table->timestamps();

            $table->unique(['reglamento_id', 'trabajador_id']); // evita duplicados
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reglamento_entregas');
    }
};
