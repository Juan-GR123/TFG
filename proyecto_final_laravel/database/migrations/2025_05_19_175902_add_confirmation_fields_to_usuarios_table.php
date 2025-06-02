<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('token_confirmacion', 60)->nullable()->change();
            $table->boolean('email_confirmado')->default(false);
        });
    }

    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Volver a dejar el campo como estaba (ajusta según tu estado anterior)
            $table->string('token_confirmacion')->nullable(false)->change();
            $table->dropColumn('email_confirmado');
        });
    }
};

