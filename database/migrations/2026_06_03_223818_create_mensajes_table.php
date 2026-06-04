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
        Schema::create('mensajes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('empresa_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('remitente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('titulo', 255);

            $table->text('mensaje');

            $table->boolean('para_todos')
                ->default(false);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};