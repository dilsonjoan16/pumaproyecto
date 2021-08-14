<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSorteosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('sorteos', function (Blueprint $table) {
            $table->id();
            $table->date("Fecha");
            $table->string("Loteria");
            $table->string("Codigo");
            $table->integer("Max")->nullable();
            $table->integer("Estado")->default(1); //1 ACTIVO 0 INACTIVO
            $table->integer("porc_4cifras")->nullable();
            $table->integer("porc_triple")->nullable();
            $table->integer("porc_combn3")->nullable();
            $table->integer("porc_combn4")->nullable();
            $table->integer("porc_terminal")->nullable();
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
        Schema::dropIfExists('sorteos');
    }
}
