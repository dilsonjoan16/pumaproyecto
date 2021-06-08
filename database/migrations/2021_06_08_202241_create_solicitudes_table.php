<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->id();
            $table->string("Nombre");
            $table->integer("Cantidadsolicitada")->nullable();
            $table->integer("Cuotas")->nullable();
            $table->string("MobiliarioSolicitado")->nullable();
            $table->string("Ubicacion")->nullable();
            $table->string("Solicitud")->nullable();
            $table->integer("Tipo")->default(1);
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
        Schema::dropIfExists('solicitudes');
    }
}
