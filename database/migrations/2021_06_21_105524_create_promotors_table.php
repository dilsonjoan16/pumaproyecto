<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->integer('dni');
            $table->integer('ganancia')->nullable();
            $table->integer('porcentaje')->nullable();
            $table->integer('balance')->nullable();
            $table->string('foto');
            $table->string('direccion');
            $table->bigInteger('telefono');
            $table->string('codigo')->nullable();
            $table->integer('tipo')->default(1);
            $table->string('busqueda')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotors');
    }
}
