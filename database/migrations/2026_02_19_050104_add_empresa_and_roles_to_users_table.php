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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('empresa_id')->nullable()->constrained('empresas')->nullOnDelete();
            $table->enum('rol', ['admin_primario', 'admin_secundario', 'trabajador'])->default('trabajador');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->boolean('must_change_password')->default(true);
            $table->timestamp('last_login_at')->nullable();

            $table->unique(['empresa_id', 'email']); // email único por empresa
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
