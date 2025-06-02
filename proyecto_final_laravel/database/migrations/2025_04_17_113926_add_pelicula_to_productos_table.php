<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->string('pelicula')->nullable()->after('trailer'); // O después de la columna que quieras
    });
}

public function down()
{
    Schema::table('productos', function (Blueprint $table) {
        $table->dropColumn('pelicula');
    });
}
};
