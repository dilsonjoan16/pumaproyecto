<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customizes', function (Blueprint $table) {
            $table->id();
            $table->string('rutaImagen')->nullable();
            $table->string('titulo');
            $table->string('contenido');
            $table->string('rutaVideo')->nullable();
            $table->integer('orden'); //manera de ordenar las galerias
            $table->integer('estado')->default(1);  //para el borrado logico : 1 aparece 2 oculto 3 borrado-logico
            $table->integer('tipo'); //1 resultados 2 sorteos 3 testimonios 4 ubicanos 5 contacto
            $table->string('link');
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
        Schema::dropIfExists('customizes');
    }
}
