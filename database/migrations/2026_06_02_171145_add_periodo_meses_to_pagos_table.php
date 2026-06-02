<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pagos', function (Blueprint $table) {

            $table->integer('periodo_meses')
                ->nullable()
                ->after('monto');

        });
    }

    public function down(): void
    {
        Schema::table('pagos', function (Blueprint $table) {

            $table->dropColumn('periodo_meses');

        });
    }
};