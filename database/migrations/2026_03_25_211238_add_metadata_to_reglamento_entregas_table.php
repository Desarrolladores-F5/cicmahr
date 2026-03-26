<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('reglamento_entregas', function (Blueprint $table) {
            $table->string('ip')->nullable();
            $table->text('user_agent')->nullable();
        });
    }

    public function down()
    {
        Schema::table('reglamento_entregas', function (Blueprint $table) {
            $table->dropColumn(['ip', 'user_agent']);
        });
    }
};
