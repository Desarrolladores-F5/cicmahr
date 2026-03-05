<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('trabajadores', function (Blueprint $table) {
            $table->string('email_contacto')->nullable()->after('rut');
        });
    }

    public function down()
    {
        Schema::table('trabajadores', function (Blueprint $table) {
            $table->dropColumn('email_contacto');
        });
    }
};
