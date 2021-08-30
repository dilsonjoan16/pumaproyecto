<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reportes', function (Blueprint $table) {
            $table->id();
            $table->integer("Monto");
            $table->integer("MontoCredito")->nullable();
            $table->string("Salida");
            $table->string("Tipo");
            $table->string("Descripcion")->nullable();
            $table->string("Referencia")->nullable();
            $table->string("Transaccion")->nullable();
            $table->integer("user_pago")->nullable();
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
        Schema::dropIfExists('reportes');
    }
}
