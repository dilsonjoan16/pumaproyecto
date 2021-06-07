<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->date("Fecha");
            $table->integer("Numero");
            $table->integer("Valorapuesta");
            $table->string("Loteria");
            $table->string("Tipo");
            //Menu lateral de las vistas
            $table->integer("Sumatotalventas");
            $table->string("Puntoventas");
            $table->string("Nombrepromotor");
            $table->string("Puntoentregaventas");
            $table->timestamps();
        });
        /*"Fecha",
        "Numero",
        "Valorapuesta",
        "Loteria",
        "Tipo" //Directo o Combinado */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}
