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
        Schema::create('procesos_carga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id');

            $table->integer('total_archivos')->default(0);
            $table->integer('procesados')->default(0);
            $table->integer('asignados')->default(0);
            $table->integer('no_encontrados')->default(0);

            $table->string('estado')->default('procesando');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesos_carga');
    }
};
