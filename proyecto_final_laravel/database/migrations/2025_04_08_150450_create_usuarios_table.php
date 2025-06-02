<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255)->nullable();
            $table->string('rol', 20);
            $table->string('imagen')->nullable();
            $table->timestamps();
        });

         // En la migración de usuarios
         Schema::table('usuarios', function (Blueprint $table) {
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
