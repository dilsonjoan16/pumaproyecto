<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministradorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administradors', function (Blueprint $table) {
            $table->id();
            $table->integer("Referencia");
            $table->integer("Numero");
            $table->integer("Valorapostado");
            $table->string("Loteria");
            $table->string("Usuario");
            $table->string("Transaccion");
            $table->timestamps();
            
            /*'Fecha',
        'Transaccion', //Esto es Gasto, Pago, Premio
        'Monto',
        'Referencia',
        'Salida', // Esto es Acumulado o Caja
        'Numero',
        'Valorapostado',
        'Loteria',
        'Tipo',*/ 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administradors');
    }
}
