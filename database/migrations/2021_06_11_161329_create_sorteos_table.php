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
            $table->string("NombreSorteo");
            $table->integer("Tipo"); //1->SORTEO, 2->RIFA, 3->APUESTA, ETC
            $table->date("FechaCulminacion");
            $table->integer("Numeros");
            $table->integer("Estado")->default(1); //1 ACTIVO 0 INACTIVO
            $table->string("NombreGanador")->nullable();
            $table->string("Vendedor")->nullable();
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
